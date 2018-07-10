<?php
// +----------------------------------------------------------------------+
// | Anuko Time Tracker
// +----------------------------------------------------------------------+
// | Copyright (c) Anuko International Ltd. (https://www.anuko.com)
// +----------------------------------------------------------------------+
// | LIBERAL FREEWARE LICENSE: This source code document may be used
// | by anyone for any purpose, and freely redistributed alone or in
// | combination with other software, provided that the license is obeyed.
// |
// | There are only two ways to violate the license:
// |
// | 1. To redistribute this code in source form, with the copyright
// |    notice or license removed or altered. (Distributing in compiled
// |    forms without embedded copyright notices is permitted).
// |
// | 2. To redistribute modified versions of this code in *any* form
// |    that bears insufficient indications that the modifications are
// |    not the work of the original author(s).
// |
// | This license applies to this document only, not any other software
// | that it may be combined with.
// |
// +----------------------------------------------------------------------+
// | Contributors:
// | https://www.anuko.com/time_tracker/credits.htm
// +----------------------------------------------------------------------+

//require_once('../../initialize.php');
require_once(LIBRARY_DIR . '/tdcron/class.tdcron.php');
require_once(LIBRARY_DIR . '/tdcron/class.tdcron.entry.php');
require_once (LIBRARY_DIR. '/EmailSender.php');

import('ttClientHelper');
import('DateAndTime');
import('Period');
import('ttTimeHelper');
import('ttFavReportHelper');
import('ttReportHelper');




require_once(dirname(__FILE__).'/../../plugins/CustomFields.class.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


// Class ttReportHelper is used for help with reports.
class ttReportHelper {

    // getWhere prepares a WHERE clause for a report query.
    static function getWhere($bean) {
        global $user;

        // Prepare dropdown parts.
        $dropdown_parts = '';
        if ($bean->getAttribute('client'))
            $dropdown_parts .= ' and l.client_id = '.$bean->getAttribute('client');
        elseif ($user->isClient() && $user->client_id)
            $dropdown_parts .= ' and l.client_id = '.$user->client_id;
        if ($bean->getAttribute('option')) $dropdown_parts .= ' and l.id in(select log_id from tt_custom_field_log where status = 1 and option_id = '.$bean->getAttribute('option').')';
        if ($bean->getAttribute('project')) $dropdown_parts .= ' and l.project_id = '.$bean->getAttribute('project');
        if ($bean->getAttribute('task')) $dropdown_parts .= ' and l.task_id = '.$bean->getAttribute('task');
        if ($bean->getAttribute('include_records')=='1') $dropdown_parts .= ' and l.billable = 1';
        if ($bean->getAttribute('include_records')=='2') $dropdown_parts .= ' and l.billable = 0';
        if ($bean->getAttribute('invoice')=='1') $dropdown_parts .= ' and l.invoice_id is not NULL';
        if ($bean->getAttribute('invoice')=='2') $dropdown_parts .= ' and l.invoice_id is NULL';
        if ($bean->getAttribute('paid_status')=='1') $dropdown_parts .= ' and l.paid = 1';
        if ($bean->getAttribute('paid_status')=='2') $dropdown_parts .= ' and l.paid = 0';

        // Prepare user list part.
        $userlist = -1;
        if (($user->can('view_reports') || $user->isClient()) && is_array($bean->getAttribute('users')))
            $userlist = join(',', $bean->getAttribute('users'));
        // Prepare sql query part for user list.
        $user_list_part = null;
        if ($user->can('view_reports') || $user->isClient())
            $user_list_part = " and l.user_id in ($userlist)";
        else
            $user_list_part = " and l.user_id = ".$user->id;

        // Prepare sql query part for where.
        if ($bean->getAttribute('period'))
            $period = new Period($bean->getAttribute('period'), new DateAndTime($user->date_format));
        else {
            $period = new Period();
            $period->setPeriod(
                new DateAndTime($user->date_format, $bean->getAttribute('start_date')),
                new DateAndTime($user->date_format, $bean->getAttribute('end_date')));
        }
        $where = " where l.status = 1 and l.date >= '".$period->getStartDate(DB_DATEFORMAT)."' and l.date <= '".$period->getEndDate(DB_DATEFORMAT)."'".
            " $user_list_part $dropdown_parts";
        return $where;
    }

    // getFavWhere prepares a WHERE clause for a favorite report query.
    static function getFavWhere($report) {
        global $user;

        // Prepare dropdown parts.
        $dropdown_parts = '';
        if ($report['client_id'])
            $dropdown_parts .= ' and l.client_id = '.$report['client_id'];
        elseif ($user->isClient() && $user->client_id)
            $dropdown_parts .= ' and l.client_id = '.$user->client_id;
        if ($report['cf_1_option_id']) $dropdown_parts .= ' and l.id in(select log_id from tt_custom_field_log where status = 1 and option_id = '.$report['cf_1_option_id'].')';
        if ($report['project_id']) $dropdown_parts .= ' and l.project_id = '.$report['project_id'];
        if ($report['task_id']) $dropdown_parts .= ' and l.task_id = '.$report['task_id'];
        if ($report['billable']=='1') $dropdown_parts .= ' and l.billable = 1';
        if ($report['billable']=='2') $dropdown_parts .= ' and l.billable = 0';
        if ($report['invoice']=='1') $dropdown_parts .= ' and l.invoice_id is not NULL';
        if ($report['invoice']=='2') $dropdown_parts .= ' and l.invoice_id is NULL';
        if ($report['paid_status']=='1') $dropdown_parts .= ' and l.paid = 1';
        if ($report['paid_status']=='2') $dropdown_parts .= ' and l.paid = 0';

        // Prepare user list part.
        $userlist = -1;
        if (($user->can('view_reports') || $user->isClient())) {
            if ($report['users'])
                $userlist = $report['users'];
            else {
                $active_users = ttTeamHelper::getActiveUsers();
                foreach ($active_users as $single_user)
                    $users[] = $single_user['id'];
                $userlist = join(',', $users);
            }
        }
        // Prepare sql query part for user list.
        $user_list_part = null;
        if ($user->can('view_reports') || $user->isClient())
            $user_list_part = " and l.user_id in ($userlist)";
        else
            $user_list_part = " and l.user_id = ".$user->id;

        // Prepare sql query part for where.
        if ($report['period'])
            $period = new Period($report['period'], new DateAndTime($user->date_format));
        else {
            $period = new Period();
            $period->setPeriod(
                new DateAndTime($user->date_format, $report['period_start']),
                new DateAndTime($user->date_format, $report['period_end']));
        }
        $where = " where l.status = 1 and l.date >= '".$period->getStartDate(DB_DATEFORMAT)."' and l.date <= '".$period->getEndDate(DB_DATEFORMAT)."'".
            " $user_list_part $dropdown_parts";
        return $where;
    }

    // getExpenseWhere prepares WHERE clause for expenses query in a report.
    static function getExpenseWhere($bean) {
        global $user;

        // Prepare dropdown parts.
        $dropdown_parts = '';
        if ($bean->getAttribute('client'))
            $dropdown_parts .= ' and ei.client_id = '.$bean->getAttribute('client');
        elseif ($user->isClient() && $user->client_id)
            $dropdown_parts .= ' and ei.client_id = '.$user->client_id;
        if ($bean->getAttribute('project')) $dropdown_parts .= ' and ei.project_id = '.$bean->getAttribute('project');
        if ($bean->getAttribute('invoice')=='1') $dropdown_parts .= ' and ei.invoice_id is not NULL';
        if ($bean->getAttribute('invoice')=='2') $dropdown_parts .= ' and ei.invoice_id is NULL';
        if ($bean->getAttribute('paid_status')=='1') $dropdown_parts .= ' and ei.paid = 1';
        if ($bean->getAttribute('paid_status')=='2') $dropdown_parts .= ' and ei.paid = 0';

        // Prepare user list part.
        $userlist = -1;
        if (($user->can('view_reports') || $user->isClient()) && is_array($bean->getAttribute('users')))
            $userlist = join(',', $bean->getAttribute('users'));
        // Prepare sql query part for user list.
        $user_list_part = null;
        if ($user->can('view_reports') || $user->isClient())
            $user_list_part = " and ei.user_id in ($userlist)";
        else
            $user_list_part = " and ei.user_id = ".$user->id;

        // Prepare sql query part for where.
        if ($bean->getAttribute('period'))
            $period = new Period($bean->getAttribute('period'), new DateAndTime($user->date_format));
        else {
            $period = new Period();
            $period->setPeriod(
                new DateAndTime($user->date_format, $bean->getAttribute('start_date')),
                new DateAndTime($user->date_format, $bean->getAttribute('end_date')));
        }
        $where = " where ei.status = 1 and ei.date >= '".$period->getStartDate(DB_DATEFORMAT)."' and ei.date <= '".$period->getEndDate(DB_DATEFORMAT)."'".
            " $user_list_part $dropdown_parts";
        return $where;
    }

    // getFavExpenseWhere prepares a WHERE clause for expenses query in a favorite report.
    static function getFavExpenseWhere($report) {
        global $user;

        // Prepare dropdown parts.
        $dropdown_parts = '';
        if ($report['client_id'])
            $dropdown_parts .= ' and ei.client_id = '.$report['client_id'];
        elseif ($user->isClient() && $user->client_id)
            $dropdown_parts .= ' and ei.client_id = '.$user->client_id;
        if ($report['project_id']) $dropdown_parts .= ' and ei.project_id = '.$report['project_id'];
        if ($report['invoice']=='1') $dropdown_parts .= ' and ei.invoice_id is not NULL';
        if ($report['invoice']=='2') $dropdown_parts .= ' and ei.invoice_id is NULL';
        if ($report['paid_status']=='1') $dropdown_parts .= ' and ei.paid = 1';
        if ($report['paid_status']=='2') $dropdown_parts .= ' and ei.paid = 0';

        // Prepare user list part.
        $userlist = -1;
        if (($user->can('view_reports') || $user->isClient())) {
            if ($report['users'])
                $userlist = $report['users'];
            else {
                $active_users = ttTeamHelper::getActiveUsers();
                foreach ($active_users as $single_user)
                    $users[] = $single_user['id'];
                $userlist = join(',', $users);
            }
        }
        // Prepare sql query part for user list.
        $user_list_part = null;
        if ($user->can('view_reports') || $user->isClient())
            $user_list_part = " and ei.user_id in ($userlist)";
        else
            $user_list_part = " and ei.user_id = ".$user->id;

        // Prepare sql query part for where.
        if ($report['period'])
            $period = new Period($report['period'], new DateAndTime($user->date_format));
        else {
            $period = new Period();
            $period->setPeriod(
                new DateAndTime($user->date_format, $report['period_start']),
                new DateAndTime($user->date_format, $report['period_end']));
        }
        $where = " where ei.status = 1 and ei.date >= '".$period->getStartDate(DB_DATEFORMAT)."' and ei.date <= '".$period->getEndDate(DB_DATEFORMAT)."'".
            " $user_list_part $dropdown_parts";
        return $where;
    }

    // getItems retrieves all items associated with a report.
    // It combines tt_log and tt_expense_items in one array for presentation in one table using mysql union all.
    // Expense items use the "note" field for item name.
    static function getItems($bean) {
        global $user;
        $mdb2 = getConnection();

        // Determine these once as they are used in multiple places in this function.
        $canViewReports = $user->can('view_reports');
        $isClient = $user->isClient();

        $group_by_option = $bean->getAttribute('group_by');
        $convertTo12Hour = ('%I:%M %p' == $user->time_format) && ($bean->getAttribute('chstart') || $bean->getAttribute('chfinish'));

        // Prepare a query for time items in tt_log table.
        $fields = array(); // An array of fields for database query.
        array_push($fields, 'l.id as id');
        array_push($fields, '1 as type'); // Type 1 is for tt_log entries.
        array_push($fields, 'l.date as date');
        if($canViewReports || $isClient)
            array_push($fields, 'u.name as user');
        // Add client name if it is selected.
        if ($bean->getAttribute('chclient') || 'client' == $group_by_option)
            array_push($fields, 'c.name as client');
        // Add project name if it is selected.
        if ($bean->getAttribute('chproject') || 'project' == $group_by_option)
            array_push($fields, 'p.name as project');
        // Add task name if it is selected.
        if ($bean->getAttribute('chtask') || 'task' == $group_by_option)
            array_push($fields, 't.name as task');
        // Add custom field.
        $include_cf_1 = $bean->getAttribute('chcf_1') || 'cf_1' == $group_by_option;
        if ($include_cf_1) {
            $custom_fields = new CustomFields($user->group_id);
            $cf_1_type = $custom_fields->fields[0]['type'];
            if ($cf_1_type == CustomFields::TYPE_TEXT) {
                array_push($fields, 'cfl.value as cf_1');
            } elseif ($cf_1_type == CustomFields::TYPE_DROPDOWN) {
                array_push($fields, 'cfo.value as cf_1');
            }
        }
        // Add start time.
        if ($bean->getAttribute('chstart')) {
            array_push($fields, "l.start as unformatted_start");
            array_push($fields, "TIME_FORMAT(l.start, '%k:%i') as start");
        }
        // Add finish time.
        if ($bean->getAttribute('chfinish'))
            array_push($fields, "TIME_FORMAT(sec_to_time(time_to_sec(l.start) + time_to_sec(l.duration)), '%k:%i') as finish");
        // Add duration.
        if ($bean->getAttribute('chduration'))
            array_push($fields, "TIME_FORMAT(l.duration, '%k:%i') as duration");
        // Add note.
        if ($bean->getAttribute('chnote'))
            array_push($fields, 'l.comment as note');
        // Handle cost.
        $includeCost = $bean->getAttribute('chcost');
        if ($includeCost) {
            if (MODE_TIME == $user->tracking_mode)
                array_push($fields, "cast(l.billable * coalesce(u.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2)) as cost");   // Use default user rate.
            else
                array_push($fields, "cast(l.billable * coalesce(upb.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2)) as cost"); // Use project rate for user.
            array_push($fields, "null as expense");
        }
        // Add paid status.
        if ($canViewReports && $bean->getAttribute('chpaid'))
            array_push($fields, 'l.paid as paid');
        // Add IP address.
        if ($canViewReports && $bean->getAttribute('chip')) {
            array_push($fields, 'l.created as created');
            array_push($fields, 'l.created_ip as created_ip');
            array_push($fields, 'l.modified as modified');
            array_push($fields, 'l.modified_ip as modified_ip');
        }

        // Add invoice name if it is selected.
        if (($canViewReports || $isClient) && $bean->getAttribute('chinvoice'))
            array_push($fields, 'i.name as invoice');

        // Prepare sql query part for left joins.
        $left_joins = null;
        if ($bean->getAttribute('chclient') || 'client' == $group_by_option)
            $left_joins .= " left join tt_clients c on (c.id = l.client_id)";
        if (($canViewReports || $isClient) && $bean->getAttribute('chinvoice'))
            $left_joins .= " left join tt_invoices i on (i.id = l.invoice_id and i.status = 1)";
        if ($canViewReports || $isClient || $user->isPluginEnabled('ex'))
            $left_joins .= " left join tt_users u on (u.id = l.user_id)";
        if ($bean->getAttribute('chproject') || 'project' == $group_by_option)
            $left_joins .= " left join tt_projects p on (p.id = l.project_id)";
        if ($bean->getAttribute('chtask') || 'task' == $group_by_option)
            $left_joins .= " left join tt_tasks t on (t.id = l.task_id)";
        if ($include_cf_1) {
            if ($cf_1_type == CustomFields::TYPE_TEXT)
                $left_joins .= " left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1)";
            elseif ($cf_1_type == CustomFields::TYPE_DROPDOWN) {
                $left_joins .=  " left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1)".
                    " left join tt_custom_field_options cfo on (cfl.option_id = cfo.id)";
            }
        }
        if ($includeCost && MODE_TIME != $user->tracking_mode)
            $left_joins .= " left join tt_user_project_binds upb on (l.user_id = upb.user_id and l.project_id = upb.project_id)";

        $where = ttReportHelper::getWhere($bean);

        // Construct sql query for tt_log items.
        $sql = "select ".join(', ', $fields)." from tt_log l $left_joins $where";
        // If we don't have expense items (such as when the Expenses plugin is desabled), the above is all sql we need,
        // with an exception of sorting part, that is added in the end.

        // However, when we have expenses, we need to do a union with a separate query for expense items from tt_expense_items table.
        if ($bean->getAttribute('chcost') && $user->isPluginEnabled('ex')) { // if ex(penses) plugin is enabled

            $fields = array(); // An array of fields for database query.
            array_push($fields, 'ei.id');
            array_push($fields, '2 as type'); // Type 2 is for tt_expense_items entries.
            array_push($fields, 'ei.date');
            if($canViewReports || $isClient)
                array_push($fields, 'u.name as user');
            // Add client name if it is selected.
            if ($bean->getAttribute('chclient') || 'client' == $group_by_option)
                array_push($fields, 'c.name as client');
            // Add project name if it is selected.
            if ($bean->getAttribute('chproject') || 'project' == $group_by_option)
                array_push($fields, 'p.name as project');
            if ($bean->getAttribute('chtask') || 'task' == $group_by_option)
                array_push($fields, 'null'); // null for task name. We need to match column count for union.
            if ($bean->getAttribute('chcf_1') || 'cf_1' == $group_by_option)
                array_push($fields, 'null'); // null for cf_1.
            if ($bean->getAttribute('chstart')) {
                array_push($fields, 'null'); // null for unformatted_start.
                array_push($fields, 'null'); // null for start.
            }
            if ($bean->getAttribute('chfinish'))
                array_push($fields, 'null'); // null for finish.
            if ($bean->getAttribute('chduration'))
                array_push($fields, 'null'); // null for duration.
            // Use the note field to print item name.
            if ($bean->getAttribute('chnote'))
                array_push($fields, 'ei.name as note');
            array_push($fields, 'ei.cost as cost');
            array_push($fields, 'ei.cost as expense');
            // Add paid status.
            if ($canViewReports && $bean->getAttribute('chpaid'))
                array_push($fields, 'ei.paid as paid');
            // Add IP address.
            if ($canViewReports && $bean->getAttribute('chip')) {
                array_push($fields, 'ei.created as created');
                array_push($fields, 'ei.created_ip as created_ip');
                array_push($fields, 'ei.modified as modified');
                array_push($fields, 'ei.modified_ip as modified_ip');
            }

            // Add invoice name if it is selected.
            if (($canViewReports || $isClient) && $bean->getAttribute('chinvoice'))
                array_push($fields, 'i.name as invoice');

            // Prepare sql query part for left joins.
            $left_joins = null;
            if ($canViewReports || $isClient)
                $left_joins .= " left join tt_users u on (u.id = ei.user_id)";
            if ($bean->getAttribute('chclient') || 'client' == $group_by_option)
                $left_joins .= " left join tt_clients c on (c.id = ei.client_id)";
            if ($bean->getAttribute('chproject') || 'project' == $group_by_option)
                $left_joins .= " left join tt_projects p on (p.id = ei.project_id)";
            if (($canViewReports || $isClient) && $bean->getAttribute('chinvoice'))
                $left_joins .= " left join tt_invoices i on (i.id = ei.invoice_id and i.status = 1)";

            $where = ttReportHelper::getExpenseWhere($bean);

            // Construct sql query for expense items.
            $sql_for_expense_items = "select ".join(', ', $fields)." from tt_expense_items ei $left_joins $where";

            // Construct a union.
            $sql = "($sql) union all ($sql_for_expense_items)";
        }

        // Determine sort part.
        $sort_part = ' order by ';
        if ('no_grouping' == $group_by_option || 'date' == $group_by_option)
            $sort_part .= 'date';
        else
            $sort_part .= $group_by_option.', date';
        if (($canViewReports || $isClient) && is_array($bean->getAttribute('users')) && 'user' != $group_by_option)
            $sort_part .= ', user, type';
        if ($bean->getAttribute('chstart'))
            $sort_part .= ', unformatted_start';
        $sort_part .= ', id';

        $sql .= $sort_part;
        // By now we are ready with sql.

        // Obtain items for report.
        $res = $mdb2->query($sql);
        if (is_a($res, 'PEAR_Error')) die($res->getMessage());

        while ($val = $res->fetchRow()) {
            if ($convertTo12Hour) {
                if($val['start'] != '')
                    $val['start'] = ttTimeHelper::to12HourFormat($val['start']);
                if($val['finish'] != '')
                    $val['finish'] = ttTimeHelper::to12HourFormat($val['finish']);
            }
            if (isset($val['cost'])) {
                if ('.' != $user->decimal_mark)
                    $val['cost'] = str_replace('.', $user->decimal_mark, $val['cost']);
            }
            if (isset($val['expense'])) {
                if ('.' != $user->decimal_mark)
                    $val['expense'] = str_replace('.', $user->decimal_mark, $val['expense']);
            }
            if ('no_grouping' != $group_by_option) {
                $val['grouped_by'] = $val[$group_by_option];
                if ('date' == $group_by_option) {
                    // This is needed to get the date in user date format.
                    $o_date = new DateAndTime(DB_DATEFORMAT, $val['grouped_by']);
                    $val['grouped_by'] = $o_date->toString($user->date_format);
                    unset($o_date);
                }
            }

            // This is needed to get the date in user date format.
            $o_date = new DateAndTime(DB_DATEFORMAT, $val['date']);
            $val['date'] = $o_date->toString($user->date_format);
            unset($o_date);

            $row = $val;
            $report_items[] = $row;
        }

        return $report_items;
    }

    // putInSession stores tt_log and tt_expense_items ids from a report in user session
    // as 2 comma-separated lists.
    static function putInSession($report_items) {
        unset($_SESSION['report_item_ids']);
        unset($_SESSION['report_item_expense_ids']);

        // Iterate through records and build 2 comma-separated lists.
        foreach($report_items as $item) {
            if ($item['type'] == 1)
                $report_item_ids .= ','.$item['id'];
            else if ($item['type'] == 2)
                $report_item_expense_ids .= ','.$item['id'];
        }
        $report_item_ids = trim($report_item_ids, ',');
        $report_item_expense_ids = trim($report_item_expense_ids, ',');

        // The lists are reqdy. Put them in session.
        if ($report_item_ids) $_SESSION['report_item_ids'] = $report_item_ids;
        if ($report_item_expense_ids) $_SESSION['report_item_expense_ids'] = $report_item_expense_ids;
    }

    // getFromSession obtains tt_log and tt_expense_items ids stored in user session.
    static function getFromSession() {
        $items = array();
        $report_item_ids = $_SESSION['report_item_ids'];
        if ($report_item_ids)
            $items['report_item_ids'] = explode(',', $report_item_ids);
        $report_item_expense_ids = $_SESSION['report_item_expense_ids'];
        if ($report_item_expense_ids)
            $items['report_item_expense_ids'] = explode(',', $report_item_expense_ids);
        return $items;
    }

    // getFavItems retrieves all items associated with a favorite report.
    // It combines tt_log and tt_expense_items in one array for presentation in one table using mysql union all.
    // Expense items use the "note" field for item name.
    static function getFavItems($report) {
        global $user;
        $mdb2 = getConnection();

        // Determine these once as they are used in multiple places in this function.
        $canViewReports = $user->can('view_reports');
        $isClient = $user->isClient();

        $group_by_option = $report['group_by'];
        $convertTo12Hour = ('%I:%M %p' == $user->time_format) && ($report['show_start'] || $report['show_end']);

        // Prepare a query for time items in tt_log table.
        $fields = array(); // An array of fields for database query.
        array_push($fields, 'l.id as id');
        array_push($fields, '1 as type'); // Type 1 is for tt_log entries.
        array_push($fields, 'l.date as date');
        if($canViewReports || $isClient)
            array_push($fields, 'u.name as user');
        // Add client name if it is selected.
        if ($report['show_client'] || 'client' == $group_by_option)
            array_push($fields, 'c.name as client');
        // Add project name if it is selected.
        if ($report['show_project'] || 'project' == $group_by_option)
            array_push($fields, 'p.name as project');
        // Add task name if it is selected.
        if ($report['show_task'] || 'task' == $group_by_option)
            array_push($fields, 't.name as task');
        // Add custom field.
        $include_cf_1 = $report['show_custom_field_1'] || 'cf_1' == $group_by_option;
        if ($include_cf_1) {
            $custom_fields = new CustomFields($user->group_id);
            $cf_1_type = $custom_fields->fields[0]['type'];
            if ($cf_1_type == CustomFields::TYPE_TEXT) {
                array_push($fields, 'cfl.value as cf_1');
            } elseif ($cf_1_type == CustomFields::TYPE_DROPDOWN) {
                array_push($fields, 'cfo.value as cf_1');
            }
        }
        // Add start time.
        if ($report['show_start']) {
            array_push($fields, "l.start as unformatted_start");
            array_push($fields, "TIME_FORMAT(l.start, '%k:%i') as start");
        }
        // Add finish time.
        if ($report['show_end'])
            array_push($fields, "TIME_FORMAT(sec_to_time(time_to_sec(l.start) + time_to_sec(l.duration)), '%k:%i') as finish");
        // Add duration.
        if ($report['show_duration'])
            array_push($fields, "TIME_FORMAT(l.duration, '%k:%i') as duration");
        // Add note.
        if ($report['show_note'])
            array_push($fields, 'l.comment as note');
        // Handle cost.
        $includeCost = $report['show_cost'];
        if ($includeCost) {
            if (MODE_TIME == $user->tracking_mode)
                array_push($fields, "cast(l.billable * coalesce(u.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2)) as cost");   // Use default user rate.
            else
                array_push($fields, "cast(l.billable * coalesce(upb.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2)) as cost"); // Use project rate for user.
            array_push($fields, "null as expense");
        }
        // Add paid status.
        if ($canViewReports && $report['show_paid'])
            array_push($fields, 'l.paid as paid');
        // Add IP address.
        if ($canViewReports && $report['show_ip']) {
            array_push($fields, 'l.created as created');
            array_push($fields, 'l.created_ip as created_ip');
            array_push($fields, 'l.modified as modified');
            array_push($fields, 'l.modified_ip as modified_ip');
        }
        // Add invoice name if it is selected.
        if (($canViewReports || $isClient) && $report['show_invoice'])
            array_push($fields, 'i.name as invoice');

        // Prepare sql query part for left joins.
        $left_joins = null;
        if ($report['show_client'] || 'client' == $group_by_option)
            $left_joins .= " left join tt_clients c on (c.id = l.client_id)";
        if (($canViewReports || $isClient) && $report['show_invoice'])
            $left_joins .= " left join tt_invoices i on (i.id = l.invoice_id and i.status = 1)";
        if ($canViewReports || $isClient || $user->isPluginEnabled('ex'))
            $left_joins .= " left join tt_users u on (u.id = l.user_id)";
        if ($report['show_project'] || 'project' == $group_by_option)
            $left_joins .= " left join tt_projects p on (p.id = l.project_id)";
        if ($report['show_task'] || 'task' == $group_by_option)
            $left_joins .= " left join tt_tasks t on (t.id = l.task_id)";
        if ($include_cf_1) {
            if ($cf_1_type == CustomFields::TYPE_TEXT)
                $left_joins .= " left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1)";
            elseif ($cf_1_type == CustomFields::TYPE_DROPDOWN) {
                $left_joins .=  " left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1)".
                    " left join tt_custom_field_options cfo on (cfl.option_id = cfo.id)";
            }
        }
        if ($includeCost && MODE_TIME != $user->tracking_mode)
            $left_joins .= " left join tt_user_project_binds upb on (l.user_id = upb.user_id and l.project_id = upb.project_id)";

        $where = ttReportHelper::getFavWhere($report);

        // Construct sql query for tt_log items.
        $sql = "select ".join(', ', $fields)." from tt_log l $left_joins $where";
        // If we don't have expense items (such as when the Expenses plugin is desabled), the above is all sql we need,
        // with an exception of sorting part, that is added in the end.

        // However, when we have expenses, we need to do a union with a separate query for expense items from tt_expense_items table.
        if ($report['show_cost'] && $user->isPluginEnabled('ex')) { // if ex(penses) plugin is enabled

            $fields = array(); // An array of fields for database query.
            array_push($fields, 'ei.id');
            array_push($fields, '2 as type'); // Type 2 is for tt_expense_items entries.
            array_push($fields, 'ei.date');
            if($canViewReports || $isClient)
                array_push($fields, 'u.name as user');
            // Add client name if it is selected.
            if ($report['show_client'] || 'client' == $group_by_option)
                array_push($fields, 'c.name as client');
            // Add project name if it is selected.
            if ($report['show_project'] || 'project' == $group_by_option)
                array_push($fields, 'p.name as project');
            if ($report['show_task'] || 'task' == $group_by_option)
                array_push($fields, 'null'); // null for task name. We need to match column count for union.
            if ($report['show_custom_field_1'] || 'cf_1' == $group_by_option)
                array_push($fields, 'null'); // null for cf_1.
            if ($report['show_start']) {
                array_push($fields, 'null'); // null for unformatted_start.
                array_push($fields, 'null'); // null for start.
            }
            if ($report['show_end'])
                array_push($fields, 'null'); // null for finish.
            if ($report['show_duration'])
                array_push($fields, 'null'); // null for duration.
            // Use the note field to print item name.
            if ($report['show_note'])
                array_push($fields, 'ei.name as note');
            array_push($fields, 'ei.cost as cost');
            array_push($fields, 'ei.cost as expense');
            // Add paid status.
            if ($canViewReports && $report['show_paid'])
                array_push($fields, 'ei.paid as paid');
            // Add IP address.
            if ($canViewReports && $report['show_ip']) {
                array_push($fields, 'ei.created as created');
                array_push($fields, 'ei.created_ip as created_ip');
                array_push($fields, 'ei.modified as modified');
                array_push($fields, 'ei.modified_ip as modified_ip');
            }
            // Add invoice name if it is selected.
            if (($canViewReports || $isClient) && $report['show_invoice'])
                array_push($fields, 'i.name as invoice');

            // Prepare sql query part for left joins.
            $left_joins = null;
            if ($canViewReports || $isClient)
                $left_joins .= " left join tt_users u on (u.id = ei.user_id)";
            if ($report['show_client'] || 'client' == $group_by_option)
                $left_joins .= " left join tt_clients c on (c.id = ei.client_id)";
            if ($report['show_project'] || 'project' == $group_by_option)
                $left_joins .= " left join tt_projects p on (p.id = ei.project_id)";
            if (($canViewReports || $isClient) && $report['show_invoice'])
                $left_joins .= " left join tt_invoices i on (i.id = ei.invoice_id and i.status = 1)";

            $where = ttReportHelper::getFavExpenseWhere($report);

            // Construct sql query for expense items.
            $sql_for_expense_items = "select ".join(', ', $fields)." from tt_expense_items ei $left_joins $where";

            // Construct a union.
            $sql = "($sql) union all ($sql_for_expense_items)";
        }

        // Determine sort part.
        $sort_part = ' order by ';
        if ($group_by_option == null || 'no_grouping' == $group_by_option || 'date' == $group_by_option) // TODO: fix DB for NULL values in group_by field.
            $sort_part .= 'date';
        else
            $sort_part .= $group_by_option.', date';
        if (($canViewReports || $isClient) /*&& is_array($bean->getAttribute('users'))*/ && 'user' != $group_by_option)
            $sort_part .= ', user, type';
        if ($report['show_start'])
            $sort_part .= ', unformatted_start';
        $sort_part .= ', id';

        $sql .= $sort_part;
        // By now we are ready with sql.

        // Obtain items for report.
        $res = $mdb2->query($sql);
        if (is_a($res, 'PEAR_Error')) die($res->getMessage());

        while ($val = $res->fetchRow()) {
            if ($convertTo12Hour) {
                if($val['start'] != '')
                    $val['start'] = ttTimeHelper::to12HourFormat($val['start']);
                if($val['finish'] != '')
                    $val['finish'] = ttTimeHelper::to12HourFormat($val['finish']);
            }
            if (isset($val['cost'])) {
                if ('.' != $user->decimal_mark)
                    $val['cost'] = str_replace('.', $user->decimal_mark, $val['cost']);
            }
            if (isset($val['expense'])) {
                if ('.' != $user->decimal_mark)
                    $val['expense'] = str_replace('.', $user->decimal_mark, $val['expense']);
            }
            if ('no_grouping' != $group_by_option) {
                $val['grouped_by'] = $val[$group_by_option];
                if ('date' == $group_by_option) {
                    // This is needed to get the date in user date format.
                    $o_date = new DateAndTime(DB_DATEFORMAT, $val['grouped_by']);
                    $val['grouped_by'] = $o_date->toString($user->date_format);
                    unset($o_date);
                }
            }

            // This is needed to get the date in user date format.
            $o_date = new DateAndTime(DB_DATEFORMAT, $val['date']);
            $val['date'] = $o_date->toString($user->date_format);
            unset($o_date);

            $row = $val;
            $report_items[] = $row;
        }

        return $report_items;
    }

    // getSubtotals calculates report items subtotals when a report is grouped by.
    // Without expenses, it's a simple select with group by.
    // With expenses, it becomes a select with group by from a combined set of records obtained with "union all".
    static function getSubtotals($bean) {
        global $user;

        $group_by_option = $bean->getAttribute('group_by');
        if ('no_grouping' == $group_by_option) return null;

        $mdb2 = getConnection();

        // Start with sql to obtain subtotals for time items. This simple sql will be used when we have no expenses.

        // Determine group by field and a required join.
        switch ($group_by_option) {
            case 'date':
                $group_field = 'l.date';
                $group_join = '';
                break;
            case 'user':
                $group_field = 'u.name';
                $group_join = 'left join tt_users u on (l.user_id = u.id) ';
                break;
            case 'client':
                $group_field = 'c.name';
                $group_join = 'left join tt_clients c on (l.client_id = c.id) ';
                break;
            case 'project':
                $group_field = 'p.name';
                $group_join = 'left join tt_projects p on (l.project_id = p.id) ';
                break;
            case 'task':
                $group_field = 't.name';
                $group_join = 'left join tt_tasks t on (l.task_id = t.id) ';
                break;
            case 'cf_1':
                $group_field = 'cfo.value';
                $custom_fields = new CustomFields($user->group_id);
                if ($custom_fields->fields[0]['type'] == CustomFields::TYPE_TEXT)
                    $group_join = 'left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1) left join tt_custom_field_options cfo on (cfl.value = cfo.id) ';
                elseif ($custom_fields->fields[0]['type'] == CustomFields::TYPE_DROPDOWN)
                    $group_join = 'left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1) left join tt_custom_field_options cfo on (cfl.option_id = cfo.id) ';
                break;
        }

        $where = ttReportHelper::getWhere($bean);
        if ($bean->getAttribute('chcost')) {
            if (MODE_TIME == $user->tracking_mode) {
                if ($group_by_option != 'user')
                    $left_join = 'left join tt_users u on (l.user_id = u.id)';
                $sql = "select $group_field as group_field, sum(time_to_sec(l.duration)) as time, 
          sum(cast(l.billable * coalesce(u.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10, 2))) as cost,
          null as expenses from tt_log l
          $group_join $left_join $where group by $group_field";
            } else {
                // If we are including cost and tracking projects, our query (the same as above) needs to join the tt_user_project_binds table.
                $sql = "select $group_field as group_field, sum(time_to_sec(l.duration)) as time, 
          sum(cast(l.billable * coalesce(upb.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2))) as cost,
          null as expenses from tt_log l
          $group_join
          left join tt_user_project_binds upb on (l.user_id = upb.user_id and l.project_id = upb.project_id) $where group by $group_field";
            }
        } else {
            $sql = "select $group_field as group_field, sum(time_to_sec(l.duration)) as time, null as expenses from tt_log l
         $group_join $where group by $group_field";
        }
        // By now we have sql for time items.

        // However, when we have expenses, we need to do a union with a separate query for expense items from tt_expense_items table.
        if ($bean->getAttribute('chcost') && $user->isPluginEnabled('ex')) { // if ex(penses) plugin is enabled

            // Determine group by field and a required join.
            $group_join = null;
            $group_field = 'null';
            switch ($group_by_option) {
                case 'date':
                    $group_field = 'ei.date';
                    $group_join = '';
                    break;
                case 'user':
                    $group_field = 'u.name';
                    $group_join = 'left join tt_users u on (ei.user_id = u.id) ';
                    break;
                case 'client':
                    $group_field = 'c.name';
                    $group_join = 'left join tt_clients c on (ei.client_id = c.id) ';
                    break;
                case 'project':
                    $group_field = 'p.name';
                    $group_join = 'left join tt_projects p on (ei.project_id = p.id) ';
                    break;
            }

            $where = ttReportHelper::getExpenseWhere($bean);
            $sql_for_expenses = "select $group_field as group_field, null as time, sum(ei.cost) as cost, sum(ei.cost) as expenses from tt_expense_items ei 
        $group_join $where";
            // Add a "group by" clause if we are grouping.
            if ('null' != $group_field) $sql_for_expenses .= " group by $group_field";

            // Create a combined query.
            $sql = "select group_field, sum(time) as time, sum(cost) as cost, sum(expenses) as expenses from (($sql) union all ($sql_for_expenses)) t group by group_field";
        }

        // Execute query.
        $res = $mdb2->query($sql);
        if (is_a($res, 'PEAR_Error')) die($res->getMessage());

        while ($val = $res->fetchRow()) {
            if ('date' == $group_by_option) {
                // This is needed to get the date in user date format.
                $o_date = new DateAndTime(DB_DATEFORMAT, $val['group_field']);
                $val['group_field'] = $o_date->toString($user->date_format);
                unset($o_date);
            }
            $time = $val['time'] ? sec_to_time_fmt_hm($val['time']) : null;
            if ($bean->getAttribute('chcost')) {
                if ('.' != $user->decimal_mark) {
                    $val['cost'] = str_replace('.', $user->decimal_mark, $val['cost']);
                    $val['expenses'] = str_replace('.', $user->decimal_mark, $val['expenses']);
                }
                $subtotals[$val['group_field']] = array('name'=>$val['group_field'],'time'=>$time,'cost'=>$val['cost'],'expenses'=>$val['expenses']);
            } else
                $subtotals[$val['group_field']] = array('name'=>$val['group_field'],'time'=>$time);
        }

        return $subtotals;
    }

    // getFavSubtotals calculates report items subtotals when a favorite report is grouped by.
    // Without expenses, it's a simple select with group by.
    // With expenses, it becomes a select with group by from a combined set of records obtained with "union all".
    static function getFavSubtotals($report) {
        global $user;

        $group_by_option = $report['group_by'];
        if ('no_grouping' == $group_by_option) return null;

        $mdb2 = getConnection();

        // Start with sql to obtain subtotals for time items. This simple sql will be used when we have no expenses.

        // Determine group by field and a required join.
        switch ($group_by_option) {
            case 'date':
                $group_field = 'l.date';
                $group_join = '';
                break;
            case 'user':
                $group_field = 'u.name';
                $group_join = 'left join tt_users u on (l.user_id = u.id) ';
                break;
            case 'client':
                $group_field = 'c.name';
                $group_join = 'left join tt_clients c on (l.client_id = c.id) ';
                break;
            case 'project':
                $group_field = 'p.name';
                $group_join = 'left join tt_projects p on (l.project_id = p.id) ';
                break;
            case 'task':
                $group_field = 't.name';
                $group_join = 'left join tt_tasks t on (l.task_id = t.id) ';
                break;
            case 'cf_1':
                $group_field = 'cfo.value';
                $custom_fields = new CustomFields($user->group_id);
                if ($custom_fields->fields[0]['type'] == CustomFields::TYPE_TEXT)
                    $group_join = 'left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1) left join tt_custom_field_options cfo on (cfl.value = cfo.id) ';
                elseif ($custom_fields->fields[0]['type'] == CustomFields::TYPE_DROPDOWN)
                    $group_join = 'left join tt_custom_field_log cfl on (l.id = cfl.log_id and cfl.status = 1) left join tt_custom_field_options cfo on (cfl.option_id = cfo.id) ';
                break;
        }

        $where = ttReportHelper::getFavWhere($report);
        if ($report['show_cost']) {
            if (MODE_TIME == $user->tracking_mode) {
                if ($group_by_option != 'user')
                    $left_join = 'left join tt_users u on (l.user_id = u.id)';
                $sql = "select $group_field as group_field, sum(time_to_sec(l.duration)) as time, 
          sum(cast(l.billable * coalesce(u.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10, 2))) as cost,
          null as expenses from tt_log l
          $group_join $left_join $where group by $group_field";
            } else {
                // If we are including cost and tracking projects, our query (the same as above) needs to join the tt_user_project_binds table.
                $sql = "select $group_field as group_field, sum(time_to_sec(l.duration)) as time, 
          sum(cast(l.billable * coalesce(upb.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2))) as cost,
          null as expenses from tt_log l 
          $group_join
          left join tt_user_project_binds upb on (l.user_id = upb.user_id and l.project_id = upb.project_id) $where group by $group_field";
            }
        } else {
            $sql = "select $group_field as group_field, sum(time_to_sec(l.duration)) as time, null as expenses from tt_log l 
         $group_join $where group by $group_field";
        }
        // By now we have sql for time items.

        // However, when we have expenses, we need to do a union with a separate query for expense items from tt_expense_items table.
        if ($report['show_cost'] && $user->isPluginEnabled('ex')) { // if ex(penses) plugin is enabled

            // Determine group by field and a required join.
            $group_join = null;
            $group_field = 'null';
            switch ($group_by_option) {
                case 'date':
                    $group_field = 'ei.date';
                    $group_join = '';
                    break;
                case 'user':
                    $group_field = 'u.name';
                    $group_join = 'left join tt_users u on (ei.user_id = u.id) ';
                    break;
                case 'client':
                    $group_field = 'c.name';
                    $group_join = 'left join tt_clients c on (ei.client_id = c.id) ';
                    break;
                case 'project':
                    $group_field = 'p.name';
                    $group_join = 'left join tt_projects p on (ei.project_id = p.id) ';
                    break;
            }

            $where = ttReportHelper::getFavExpenseWhere($report);
            $sql_for_expenses = "select $group_field as group_field, null as time, sum(ei.cost) as cost, sum(ei.cost) as expenses from tt_expense_items ei 
        $group_join $where";
            // Add a "group by" clause if we are grouping.
            if ('null' != $group_field) $sql_for_expenses .= " group by $group_field";

            // Create a combined query.
            $sql = "select group_field, sum(time) as time, sum(cost) as cost, sum(expenses) as expenses from (($sql) union all ($sql_for_expenses)) t group by group_field";
        }

        // Execute query.
        $res = $mdb2->query($sql);
        if (is_a($res, 'PEAR_Error')) die($res->getMessage());

        while ($val = $res->fetchRow()) {
            if ('date' == $group_by_option) {
                // This is needed to get the date in user date format.
                $o_date = new DateAndTime(DB_DATEFORMAT, $val['group_field']);
                $val['group_field'] = $o_date->toString($user->date_format);
                unset($o_date);
            }
            $time = $val['time'] ? sec_to_time_fmt_hm($val['time']) : null;
            if ($report['show_cost']) {
                if ('.' != $user->decimal_mark) {
                    $val['cost'] = str_replace('.', $user->decimal_mark, $val['cost']);
                    $val['expenses'] = str_replace('.', $user->decimal_mark, $val['expenses']);
                }
                $subtotals[$val['group_field']] = array('name'=>$val['group_field'],'time'=>$time,'cost'=>$val['cost'],'expenses'=>$val['expenses']);
            } else
                $subtotals[$val['group_field']] = array('name'=>$val['group_field'],'time'=>$time);
        }

        return $subtotals;
    }

    // getTotals calculates total hours and cost for all report items.
    static function getTotals($bean)
    {
        global $user;

        $mdb2 = getConnection();

        $where = ttReportHelper::getWhere($bean);

        // Start with a query for time items.
        if ($bean->getAttribute('chcost')) {
            if (MODE_TIME == $user->tracking_mode) {
                $sql = "select sum(time_to_sec(l.duration)) as time,
          sum(cast(l.billable * coalesce(u.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2))) as cost,
          null as expenses 
          from tt_log l
          left join tt_users u on (l.user_id = u.id) $where";
            } else {
                $sql = "select sum(time_to_sec(l.duration)) as time,
          sum(cast(l.billable * coalesce(upb.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2))) as cost,
          null as expenses
          from tt_log l
          left join tt_user_project_binds upb on (l.user_id = upb.user_id and l.project_id = upb.project_id) $where";
            }
        } else
            $sql = "select sum(time_to_sec(l.duration)) as time, null as cost, null as expenses from tt_log l $where";

        // If we have expenses, query becomes a bit more complex.
        if ($bean->getAttribute('chcost') && $user->isPluginEnabled('ex')) {
            $where = ttReportHelper::getExpenseWhere($bean);
            $sql_for_expenses = "select null as time, sum(cost) as cost, sum(cost) as expenses from tt_expense_items ei $where";
            // Create a combined query.
            $sql = "select sum(time) as time, sum(cost) as cost, sum(expenses) as expenses from (($sql) union all ($sql_for_expenses)) t";
        }

        // Execute query.
        $res = $mdb2->query($sql);
        if (is_a($res, 'PEAR_Error')) die($res->getMessage());

        $val = $res->fetchRow();
        $total_time = $val['time'] ? sec_to_time_fmt_hm($val['time']) : null;
        if ($bean->getAttribute('chcost')) {
            $total_cost = $val['cost'];
            if (!$total_cost) $total_cost = '0.00';
            if ('.' != $user->decimal_mark)
                $total_cost = str_replace('.', $user->decimal_mark, $total_cost);
            $total_expenses = $val['expenses'];
            if (!$total_expenses) $total_expenses = '0.00';
            if ('.' != $user->decimal_mark)
                $total_expenses = str_replace('.', $user->decimal_mark, $total_expenses);
        }

        if ($bean->getAttribute('period'))
            $period = new Period($bean->getAttribute('period'), new DateAndTime($user->date_format));
        else {
            $period = new Period();
            $period->setPeriod(
                new DateAndTime($user->date_format, $bean->getAttribute('start_date')),
                new DateAndTime($user->date_format, $bean->getAttribute('end_date')));
        }

        $totals['start_date'] = $period->getStartDate();
        $totals['end_date'] = $period->getEndDate();
        $totals['time'] = $total_time;
        $totals['cost'] = $total_cost;
        $totals['expenses'] = $total_expenses;

        return $totals;
    }

    // getFavTotals calculates total hours and cost for all favorite report items.
    static function getFavTotals($report)
    {
        global $user;

        $mdb2 = getConnection();

        $where = ttReportHelper::getFavWhere($report);

        // Start with a query for time items.
        if ($report['show_cost']) {
            if (MODE_TIME == $user->tracking_mode) {
                $sql = "select sum(time_to_sec(l.duration)) as time,
          sum(cast(l.billable * coalesce(u.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2))) as cost,
          null as expenses 
          from tt_log l
          left join tt_users u on (l.user_id = u.id) $where";
            } else {
                $sql = "select sum(time_to_sec(l.duration)) as time,
          sum(cast(l.billable * coalesce(upb.rate, 0) * time_to_sec(l.duration)/3600 as decimal(10,2))) as cost,
          null as expenses
          from tt_log l
          left join tt_user_project_binds upb on (l.user_id = upb.user_id and l.project_id = upb.project_id) $where";
            }
        } else
            $sql = "select sum(time_to_sec(l.duration)) as time, null as cost, null as expenses from tt_log l $where";

        // If we have expenses, query becomes a bit more complex.
        if ($report['show_cost'] && $user->isPluginEnabled('ex')) {
            $where = ttReportHelper::getFavExpenseWhere($report);
            $sql_for_expenses = "select null as time, sum(cost) as cost, sum(cost) as expenses from tt_expense_items ei $where";
            // Create a combined query.
            $sql = "select sum(time) as time, sum(cost) as cost, sum(expenses) as expenses from (($sql) union all ($sql_for_expenses)) t";
        }

        // Execute query.
        $res = $mdb2->query($sql);
        if (is_a($res, 'PEAR_Error')) die($res->getMessage());

        $val = $res->fetchRow();
        $total_time = $val['time'] ? sec_to_time_fmt_hm($val['time']) : null;
        if ($report['show_cost']) {
            $total_cost = $val['cost'];
            if (!$total_cost) $total_cost = '0.00';
            if ('.' != $user->decimal_mark)
                $total_cost = str_replace('.', $user->decimal_mark, $total_cost);
            $total_expenses = $val['expenses'];
            if (!$total_expenses) $total_expenses = '0.00';
            if ('.' != $user->decimal_mark)
                $total_expenses = str_replace('.', $user->decimal_mark, $total_expenses);
        }

        if ($report['period'])
            $period = new Period($report['period'], new DateAndTime($user->date_format));
        else {
            $period = new Period();
            $period->setPeriod(
                new DateAndTime($user->date_format, $report['period_start']),
                new DateAndTime($user->date_format, $report['period_end']));
        }

        $totals['start_date'] = $period->getStartDate();
        $totals['end_date'] = $period->getEndDate();
        $totals['time'] = $total_time;
        $totals['cost'] = $total_cost;
        $totals['expenses'] = $total_expenses;

        return $totals;
    }

    // The assignToInvoice assigns a set of records to a specific invoice.
    static function assignToInvoice($invoice_id, $time_log_ids, $expense_item_ids)
    {
        $mdb2 = getConnection();
        if ($time_log_ids) {
            $sql = "update tt_log set invoice_id = ".$mdb2->quote($invoice_id).
                " where id in(".join(', ', $time_log_ids).")";
            $affected = $mdb2->exec($sql);
            if (is_a($affected, 'PEAR_Error')) die($affected->getMessage());
        }
        if ($expense_item_ids) {
            $sql = "update tt_expense_items set invoice_id = ".$mdb2->quote($invoice_id).
                " where id in(".join(', ', $expense_item_ids).")";
            $affected = $mdb2->exec($sql);
            if (is_a($affected, 'PEAR_Error')) die($affected->getMessage());
        }
    }

    // The markPaid marks a set of records as either paid or unpaid.
    static function markPaid($time_log_ids, $expense_item_ids, $paid = true)
    {
        $mdb2 = getConnection();
        $paid_val = (int) $paid;
        if ($time_log_ids) {
            $sql = "update tt_log set paid = $paid_val where id in(".join(', ', $time_log_ids).")";
            $affected = $mdb2->exec($sql);
            if (is_a($affected, 'PEAR_Error')) die($affected->getMessage());
        }
        if ($expense_item_ids) {
            $sql = "update tt_expense_items set paid = $paid_val where id in(".join(', ', $expense_item_ids).")";
            $affected = $mdb2->exec($sql);
            if (is_a($affected, 'PEAR_Error')) die($affected->getMessage());
        }
    }

    // prepareReportBody - prepares an email body for report.
    static function prepareReportBody($bean, $comment)
    {
        global $user;
        global $i18n;

        // Determine these once as they are used in multiple places in this function.
        $canViewReports = $user->can('view_reports');
        $isClient = $user->isClient();

        $items = ttReportHelper::getItems($bean);
        $group_by = $bean->getAttribute('group_by');
        if ($group_by && 'no_grouping' != $group_by)
            $subtotals = ttReportHelper::getSubtotals($bean);
        $totals = ttReportHelper::getTotals($bean);

        // Use custom fields plugin if it is enabled.
        if ($user->isPluginEnabled('cf'))
            $custom_fields = new CustomFields($user->group_id);

        // Define some styles to use in email.
        $style_title = 'text-align: center; font-size: 15pt; font-family: Arial, Helvetica, sans-serif;';
        $tableHeader = 'font-weight: bold; background-color: #a6ccf7; text-align: left;';
        $tableHeaderCentered = 'font-weight: bold; background-color: #a6ccf7; text-align: center;';
        $rowItem = 'background-color: #ffffff;';
        $rowItemAlt = 'background-color: #f5f5f5;';
        $rowSubtotal = 'background-color: #e0e0e0;';
        $cellLeftAligned = 'text-align: left; vertical-align: top;';
        $cellRightAligned = 'text-align: right; vertical-align: top;';
        $cellLeftAlignedSubtotal = 'font-weight: bold; text-align: left; vertical-align: top;';
        $cellRightAlignedSubtotal = 'font-weight: bold; text-align: right; vertical-align: top;';

        // Start creating email body.
        $body = '<html>';
        $body .= '<head><meta http-equiv="content-type" content="text/html; charset='.CHARSET.'"></head>';
        $body .= '<body>';

        // Output title.
        $body .= '<p style="'.$style_title.'">'.$i18n->get('form.mail.report_subject').': '.$totals['start_date'].' - '.$totals['end_date'].'</p>';

        // Output comment.
        if ($comment) $body .= '<p>'.htmlspecialchars($comment).'</p>';

        if ($bean->getAttribute('chtotalsonly')) {
            // Totals only report. Output subtotals.

            // Determine group_by header.
            if ('cf_1' == $group_by)
                $group_by_header = htmlspecialchars($custom_fields->fields[0]['label']);
            else {
                $key = 'label.'.$group_by;
                $group_by_header = $i18n->get($key);
            }

            $body .= '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
            $body .= '<tr>';
            $body .= '<td style="'.$tableHeader.'">'.$group_by_header.'</td>';
            if ($bean->getAttribute('chduration'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.duration').'</td>';
            if ($bean->getAttribute('chcost'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.cost').'</td>';
            $body .= '</tr>';
            foreach($subtotals as $subtotal) {
                $body .= '<tr style="'.$rowSubtotal.'">';
                $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($subtotal['name'] ? htmlspecialchars($subtotal['name']) : '&nbsp;').'</td>';
                if ($bean->getAttribute('chduration')) {
                    $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                    if ($subtotal['time'] <> '0:00') $body .= $subtotal['time'];
                    $body .= '</td>';
                }
                if ($bean->getAttribute('chcost')) {
                    $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                    $body .= ($canViewReports || $isClient) ? $subtotal['cost'] : $subtotal['expenses'];
                    $body .= '</td>';
                }
                $body .= '</tr>';
            }

            // Print totals.
            $body .= '<tr><td>&nbsp;</td></tr>';
            $body .= '<tr style="'.$rowSubtotal.'">';
            $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.total').'</td>';
            if ($bean->getAttribute('chduration')) {
                $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                if ($totals['time'] <> '0:00') $body .= $totals['time'];
                $body .= '</td>';
            }
            if ($bean->getAttribute('chcost')) {
                $body .= '<td nowrap style="'.$cellRightAlignedSubtotal.'">'.htmlspecialchars($user->currency).' ';
                $body .= ($canViewReports || $isClient) ? $totals['cost'] : $totals['expenses'];
                $body .= '</td>';
            }
            $body .= '</tr>';

            $body .= '</table>';
        } else {
            // Regular report.

            // Print table header.
            $body .= '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
            $body .= '<tr>';
            $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.date').'</td>';
            if ($canViewReports || $isClient)
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.user').'</td>';
            if ($bean->getAttribute('chclient'))
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.client').'</td>';
            if ($bean->getAttribute('chproject'))
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.project').'</td>';
            if ($bean->getAttribute('chtask'))
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.task').'</td>';
            if ($bean->getAttribute('chcf_1'))
                $body .= '<td style="'.$tableHeader.'">'.htmlspecialchars($custom_fields->fields[0]['label']).'</td>';
            if ($bean->getAttribute('chstart'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.start').'</td>';
            if ($bean->getAttribute('chfinish'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.finish').'</td>';
            if ($bean->getAttribute('chduration'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.duration').'</td>';
            if ($bean->getAttribute('chnote'))
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.note').'</td>';
            if ($bean->getAttribute('chcost'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.cost').'</td>';
            if ($bean->getAttribute('chpaid'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.paid').'</td>';
            if ($bean->getAttribute('chip'))
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.ip').'</td>';
            if ($bean->getAttribute('chinvoice'))
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.invoice').'</td>';
            $body .= '</tr>';

            // Initialize variables to print subtotals.
            if ($items && 'no_grouping' != $group_by) {
                $print_subtotals = true;
                $first_pass = true;
                $prev_grouped_by = '';
                $cur_grouped_by = '';
            }
            // Initialize variables to alternate color of rows for different dates.
            $prev_date = '';
            $cur_date = '';
            $row_style = $rowItem;

            // Print report items.
            if (is_array($items)) {
                foreach ($items as $record) {
                    $cur_date = $record['date'];
                    // Print a subtotal row after a block of grouped items.
                    if ($print_subtotals) {
                        $cur_grouped_by = $record['grouped_by'];
                        if ($cur_grouped_by != $prev_grouped_by && !$first_pass) {
                            $body .= '<tr style="'.$rowSubtotal.'">';
                            $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.subtotal').'</td>';
                            $subtotal_name = htmlspecialchars($subtotals[$prev_grouped_by]['name']);
                            if ($canViewReports || $isClient) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'user' ? $subtotal_name : '').'</td>';
                            if ($bean->getAttribute('chclient')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'client' ? $subtotal_name : '').'</td>';
                            if ($bean->getAttribute('chproject')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'project' ? $subtotal_name : '').'</td>';
                            if ($bean->getAttribute('chtask')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'task' ? $subtotal_name : '').'</td>';
                            if ($bean->getAttribute('chcf_1')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'cf_1' ? $subtotal_name : '').'</td>';
                            if ($bean->getAttribute('chstart')) $body .= '<td></td>';
                            if ($bean->getAttribute('chfinish')) $body .= '<td></td>';
                            if ($bean->getAttribute('chduration')) $body .= '<td style="'.$cellRightAlignedSubtotal.'">'.$subtotals[$prev_grouped_by]['time'].'</td>';
                            if ($bean->getAttribute('chnote')) $body .= '<td></td>';
                            if ($bean->getAttribute('chcost')) {
                                $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                                $body .= ($canViewReports || $isClient) ? $subtotals[$prev_grouped_by]['cost'] : $subtotals[$prev_grouped_by]['expenses'];
                                $body .= '</td>';
                            }
                            if ($bean->getAttribute('chpaid')) $body .= '<td></td>';
                            if ($bean->getAttribute('chip')) $body .= '<td></td>';
                            if ($bean->getAttribute('chinvoice')) $body .= '<td></td>';
                            $body .= '</tr>';
                            $body .= '<tr><td>&nbsp;</td></tr>';
                        }
                        $first_pass = false;
                    }

                    // Print a regular row.
                    if ($cur_date != $prev_date)
                        $row_style = ($row_style == $rowItem) ? $rowItemAlt : $rowItem;
                    $body .= '<tr style="'.$row_style.'">';
                    $body .= '<td style="'.$cellLeftAligned.'">'.$record['date'].'</td>';
                    if ($canViewReports || $isClient)
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['user']).'</td>';
                    if ($bean->getAttribute('chclient'))
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['client']).'</td>';
                    if ($bean->getAttribute('chproject'))
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['project']).'</td>';
                    if ($bean->getAttribute('chtask'))
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['task']).'</td>';
                    if ($bean->getAttribute('chcf_1'))
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['cf_1']).'</td>';
                    if ($bean->getAttribute('chstart'))
                        $body .= '<td nowrap style="'.$cellRightAligned.'">'.$record['start'].'</td>';
                    if ($bean->getAttribute('chfinish'))
                        $body .= '<td nowrap style="'.$cellRightAligned.'">'.$record['finish'].'</td>';
                    if ($bean->getAttribute('chduration'))
                        $body .= '<td style="'.$cellRightAligned.'">'.$record['duration'].'</td>';
                    if ($bean->getAttribute('chnote'))
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['note']).'</td>';
                    if ($bean->getAttribute('chcost'))
                        $body .= '<td style="'.$cellRightAligned.'">'.$record['cost'].'</td>';
                    if ($bean->getAttribute('chpaid')) {
                        $body .= '<td style="'.$cellRightAligned.'">';
                        $body .= $record['paid'] == 1 ? $i18n->get('label.yes') : $i18n->get('label.no');
                        $body .= '</td>';
                    }
                    if ($bean->getAttribute('chip')) {
                        $body .= '<td style="'.$cellRightAligned.'">';
                        $body .= $record['modified'] ? $record['modified_ip'].' '.$record['modified'] : $record['created_ip'].' '.$record['created'];
                        $body .= '</td>';
                    }
                    if ($bean->getAttribute('chinvoice'))
                        $body .= '<td style="'.$cellRightAligned.'">'.htmlspecialchars($record['invoice']).'</td>';
                    $body .= '</tr>';

                    $prev_date = $record['date'];
                    if ($print_subtotals)
                        $prev_grouped_by = $record['grouped_by'];
                }
            }

            // Print a terminating subtotal.
            if ($print_subtotals) {
                $body .= '<tr style="'.$rowSubtotal.'">';
                $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.subtotal').'</td>';
                $subtotal_name = htmlspecialchars($subtotals[$cur_grouped_by]['name']);
                if ($canViewReports || $isClient) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'user' ? $subtotal_name : '').'</td>';
                if ($bean->getAttribute('chclient')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'client' ? $subtotal_name : '').'</td>';
                if ($bean->getAttribute('chproject')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'project' ? $subtotal_name : '').'</td>';
                if ($bean->getAttribute('chtask')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'task' ? $subtotal_name : '').'</td>';
                if ($bean->getAttribute('chcf_1')) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'cf_1' ? $subtotal_name : '').'</td>';
                if ($bean->getAttribute('chstart')) $body .= '<td></td>';
                if ($bean->getAttribute('chfinish')) $body .= '<td></td>';
                if ($bean->getAttribute('chduration')) $body .= '<td style="'.$cellRightAlignedSubtotal.'">'.$subtotals[$cur_grouped_by]['time'].'</td>';
                if ($bean->getAttribute('chnote')) $body .= '<td></td>';
                if ($bean->getAttribute('chcost')) {
                    $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                    $body .= ($canViewReports || $isClient) ? $subtotals[$cur_grouped_by]['cost'] : $subtotals[$cur_grouped_by]['expenses'];
                    $body .= '</td>';
                }
                if ($bean->getAttribute('chpaid')) $body .= '<td></td>';
                if ($bean->getAttribute('chip')) $body .= '<td></td>';
                if ($bean->getAttribute('chinvoice')) $body .= '<td></td>';
                $body .= '</tr>';
            }

            // Print totals.
            $body .= '<tr><td>&nbsp;</td></tr>';
            $body .= '<tr style="'.$rowSubtotal.'">';
            $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.total').'</td>';
            if ($canViewReports || $isClient) $body .= '<td></td>';
            if ($bean->getAttribute('chclient')) $body .= '<td></td>';
            if ($bean->getAttribute('chproject')) $body .= '<td></td>';
            if ($bean->getAttribute('chtask')) $body .= '<td></td>';
            if ($bean->getAttribute('chcf_1')) $body .= '<td></td>';
            if ($bean->getAttribute('chstart')) $body .= '<td></td>';
            if ($bean->getAttribute('chfinish')) $body .= '<td></td>';
            if ($bean->getAttribute('chduration')) $body .= '<td style="'.$cellRightAlignedSubtotal.'">'.$totals['time'].'</td>';
            if ($bean->getAttribute('chnote')) $body .= '<td></td>';
            if ($bean->getAttribute('chcost')) {
                $body .= '<td nowrap style="'.$cellRightAlignedSubtotal.'">'.htmlspecialchars($user->currency).' ';
                $body .= ($canViewReports || $isClient) ? $totals['cost'] : $totals['expenses'];
                $body .= '</td>';
            }
            if ($bean->getAttribute('chpaid')) $body .= '<td></td>';
            if ($bean->getAttribute('chip')) $body .= '<td></td>';
            if ($bean->getAttribute('chinvoice')) $body .= '<td></td>';
            $body .= '</tr>';

            $body .= '</table>';
        }

        // Output footer.
        if (!defined('REPORT_FOOTER') || !(REPORT_FOOTER == false))
            $body .= '<p style="text-align: center;">'.$i18n->get('form.mail.footer').'</p>';

        // Finish creating email body.
        $body .= '</body></html>';

        return $body;
    }

    // checkFavReportCondition - checks whether it is okay to send fav report.
    static function checkFavReportCondition($report, $condition)
    {
        $items = ttReportHelper::getFavItems($report);

        $condition = str_replace('count', '', $condition);
        $count_required = (int) trim(str_replace('>', '', $condition));

        if (count($items) > $count_required)
            return true; // Condition ok.

        return false;
    }

    // prepareFavReportBody - prepares an email body for a favorite report.
    static function prepareFavReportBody($report)
    {
        global $user;
        global $i18n;

        // Determine these once as they are used in multiple places in this function.
        $canViewReports = $user->can('view_reports');
        $isClient = $user->isClient();

        $items = ttReportHelper::getFavItems($report);
        $group_by = $report['group_by'];
        if ($group_by && 'no_grouping' != $group_by)
            $subtotals = ttReportHelper::getFavSubtotals($report);
        $totals = ttReportHelper::getFavTotals($report);

        // Use custom fields plugin if it is enabled.
        if ($user->isPluginEnabled('cf'))
            $custom_fields = new CustomFields($user->group_id);

        // Define some styles to use in email.
        $style_title = 'text-align: center; font-size: 15pt; font-family: Arial, Helvetica, sans-serif;';
        $tableHeader = 'font-weight: bold; background-color: #a6ccf7; text-align: left;';
        $tableHeaderCentered = 'font-weight: bold; background-color: #a6ccf7; text-align: center;';
        $rowItem = 'background-color: #ffffff;';
        $rowItemAlt = 'background-color: #f5f5f5;';
        $rowSubtotal = 'background-color: #e0e0e0;';
        $cellLeftAligned = 'text-align: left; vertical-align: top;';
        $cellRightAligned = 'text-align: right; vertical-align: top;';
        $cellLeftAlignedSubtotal = 'font-weight: bold; text-align: left; vertical-align: top;';
        $cellRightAlignedSubtotal = 'font-weight: bold; text-align: right; vertical-align: top;';

        // Start creating email body.
        $body = '<html>';
        $body .= '<head><meta http-equiv="content-type" content="text/html; charset='.CHARSET.'"></head>';
        $body .= '<body>';

        // Output title.
        $body .= '<p style="'.$style_title.'">'.$i18n->get('form.mail.report_subject').': '.$totals['start_date'].' - '.$totals['end_date'].'</p>';

        // Output comment.
        // if ($comment) $body .= '<p>'.htmlspecialchars($comment).'</p>'; // No comment for fav. reports.

        if ($report['show_totals_only']) {
            // Totals only report. Output subtotals.

            // Determine group_by header.
            if ('cf_1' == $group_by)
                $group_by_header = htmlspecialchars($custom_fields->fields[0]['label']);
            else {
                $key = 'label.'.$group_by;
                $group_by_header = $i18n->get($key);
            }

            $body .= '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
            $body .= '<tr>';
            $body .= '<td style="'.$tableHeader.'">'.$group_by_header.'</td>';
            if ($report['show_duration'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.duration').'</td>';
            if ($report['show_cost'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.cost').'</td>';
            $body .= '</tr>';
            foreach($subtotals as $subtotal) {
                $body .= '<tr style="'.$rowSubtotal.'">';
                $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($subtotal['name'] ? htmlspecialchars($subtotal['name']) : '&nbsp;').'</td>';
                if ($report['show_duration']) {
                    $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                    if ($subtotal['time'] <> '0:00') $body .= $subtotal['time'];
                    $body .= '</td>';
                }
                if ($report['show_cost']) {
                    $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                    $body .= ($canViewReports || $isClient) ? $subtotal['cost'] : $subtotal['expenses'];
                    $body .= '</td>';
                }
                $body .= '</tr>';
            }

            // Print totals.
            $body .= '<tr><td>&nbsp;</td></tr>';
            $body .= '<tr style="'.$rowSubtotal.'">';
            $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.total').'</td>';
            if ($report['show_duration']) {
                $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                if ($totals['time'] <> '0:00') $body .= $totals['time'];
                $body .= '</td>';
            }
            if ($report['show_cost']) {
                $body .= '<td nowrap style="'.$cellRightAlignedSubtotal.'">'.htmlspecialchars($user->currency).' ';
                $body .= ($canViewReports || $isClient) ? $totals['cost'] : $totals['expenses'];
                $body .= '</td>';
            }
            $body .= '</tr>';

            $body .= '</table>';
        } else {
            // Regular report.

            // Print table header.
            $body .= '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
            $body .= '<tr>';
            $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.date').'</td>';
            if ($canViewReports || $isClient)
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.user').'</td>';
            if ($report['show_client'])
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.client').'</td>';
            if ($report['show_project'])
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.project').'</td>';
            if ($report['show_task'])
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.task').'</td>';
            if ($report['show_custom_field_1'])
                $body .= '<td style="'.$tableHeader.'">'.htmlspecialchars($custom_fields->fields[0]['label']).'</td>';
            if ($report['show_start'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.start').'</td>';
            if ($report['show_end'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.finish').'</td>';
            if ($report['show_duration'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.duration').'</td>';
            if ($report['show_note'])
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.note').'</td>';
            if ($report['show_cost'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.cost').'</td>';
            if ($report['show_paid'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.paid').'</td>';
            if ($report['show_ip'])
                $body .= '<td style="'.$tableHeaderCentered.'" width="5%">'.$i18n->get('label.ip').'</td>';
            if ($report['show_invoice'])
                $body .= '<td style="'.$tableHeader.'">'.$i18n->get('label.invoice').'</td>';
            $body .= '</tr>';

            // Initialize variables to print subtotals.
            if ($items && 'no_grouping' != $group_by) {
                $print_subtotals = true;
                $first_pass = true;
                $prev_grouped_by = '';
                $cur_grouped_by = '';
            }
            // Initialize variables to alternate color of rows for different dates.
            $prev_date = '';
            $cur_date = '';
            $row_style = $rowItem;

            // Print report items.
            if (is_array($items)) {
                foreach ($items as $record) {
                    $cur_date = $record['date'];
                    // Print a subtotal row after a block of grouped items.
                    if ($print_subtotals) {
                        $cur_grouped_by = $record['grouped_by'];
                        if ($cur_grouped_by != $prev_grouped_by && !$first_pass) {
                            $body .= '<tr style="'.$rowSubtotal.'">';
                            $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.subtotal').'</td>';
                            $subtotal_name = htmlspecialchars($subtotals[$prev_grouped_by]['name']);
                            if ($canViewReports || $isClient) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'user' ? $subtotal_name : '').'</td>';
                            if ($report['show_client']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'client' ? $subtotal_name : '').'</td>';
                            if ($report['show_project']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'project' ? $subtotal_name : '').'</td>';
                            if ($report['show_task']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'task' ? $subtotal_name : '').'</td>';
                            if ($report['show_custom_field_1']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'cf_1' ? $subtotal_name : '').'</td>';
                            if ($report['show_start']) $body .= '<td></td>';
                            if ($report['show_end']) $body .= '<td></td>';
                            if ($report['show_duration']) $body .= '<td style="'.$cellRightAlignedSubtotal.'">'.$subtotals[$prev_grouped_by]['time'].'</td>';
                            if ($report['show_note']) $body .= '<td></td>';
                            if ($report['show_cost']) {
                                $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                                $body .= ($canViewReports || $isClient) ? $subtotals[$prev_grouped_by]['cost'] : $subtotals[$prev_grouped_by]['expenses'];
                                $body .= '</td>';
                            }
                            if ($report['show_paid']) $body .= '<td></td>';
                            if ($report['show_ip']) $body .= '<td></td>';
                            if ($report['show_invoice']) $body .= '<td></td>';
                            $body .= '</tr>';
                            $body .= '<tr><td>&nbsp;</td></tr>';
                        }
                        $first_pass = false;
                    }

                    // Print a regular row.
                    if ($cur_date != $prev_date)
                        $row_style = ($row_style == $rowItem) ? $rowItemAlt : $rowItem;
                    $body .= '<tr style="'.$row_style.'">';
                    $body .= '<td style="'.$cellLeftAligned.'">'.$record['date'].'</td>';
                    if ($canViewReports || $isClient)
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['user']).'</td>';
                    if ($report['show_client'])
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['client']).'</td>';
                    if ($report['show_project'])
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['project']).'</td>';
                    if ($report['show_task'])
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['task']).'</td>';
                    if ($report['show_custom_field_1'])
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['cf_1']).'</td>';
                    if ($report['show_start'])
                        $body .= '<td nowrap style="'.$cellRightAligned.'">'.$record['start'].'</td>';
                    if ($report['show_end'])
                        $body .= '<td nowrap style="'.$cellRightAligned.'">'.$record['finish'].'</td>';
                    if ($report['show_duration'])
                        $body .= '<td style="'.$cellRightAligned.'">'.$record['duration'].'</td>';
                    if ($report['show_note'])
                        $body .= '<td style="'.$cellLeftAligned.'">'.htmlspecialchars($record['note']).'</td>';
                    if ($report['show_cost'])
                        $body .= '<td style="'.$cellRightAligned.'">'.$record['cost'].'</td>';
                    if ($report['show_paid']) {
                        $body .= '<td style="'.$cellRightAligned.'">';
                        $body .= $record['paid'] == 1 ? $i18n->get('label.yes') : $i18n->get('label.no');
                        $body .= '</td>';
                    }
                    if ($report['show_ip']) {
                        $body .= '<td style="'.$cellRightAligned.'">';
                        $body .= $record['modified'] ? $record['modified_ip'].' '.$record['modified'] : $record['created_ip'].' '.$record['created'];
                        $body .= '</td>';
                    }
                    if ($report['show_invoice'])
                        $body .= '<td style="'.$cellRightAligned.'">'.htmlspecialchars($record['invoice']).'</td>';
                    $body .= '</tr>';

                    $prev_date = $record['date'];
                    if ($print_subtotals)
                        $prev_grouped_by = $record['grouped_by'];
                }
            }

            // Print a terminating subtotal.
            if ($print_subtotals) {
                $body .= '<tr style="'.$rowSubtotal.'">';
                $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.subtotal').'</td>';
                $subtotal_name = htmlspecialchars($subtotals[$cur_grouped_by]['name']);
                if ($canViewReports || $isClient) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'user' ? $subtotal_name : '').'</td>';
                if ($report['show_client']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'client' ? $subtotal_name : '').'</td>';
                if ($report['show_project']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'project' ? $subtotal_name : '').'</td>';
                if ($report['show_task']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'task' ? $subtotal_name : '').'</td>';
                if ($report['show_custom_field_1']) $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.($group_by == 'cf_1' ? $subtotal_name : '').'</td>';
                if ($report['show_start']) $body .= '<td></td>';
                if ($report['show_end']) $body .= '<td></td>';
                if ($report['show_duration']) $body .= '<td style="'.$cellRightAlignedSubtotal.'">'.$subtotals[$cur_grouped_by]['time'].'</td>';
                if ($report['show_note']) $body .= '<td></td>';
                if ($report['show_cost']) {
                    $body .= '<td style="'.$cellRightAlignedSubtotal.'">';
                    $body .= ($canViewReports || $isClient) ? $subtotals[$cur_grouped_by]['cost'] : $subtotals[$cur_grouped_by]['expenses'];
                    $body .= '</td>';
                }
                if ($report['show_paid']) $body .= '<td></td>';
                if ($report['show_ip']) $body .= '<td></td>';
                if ($report['show_invoice']) $body .= '<td></td>';
                $body .= '</tr>';
            }

            // Print totals.
            $body .= '<tr><td>&nbsp;</td></tr>';
            $body .= '<tr style="'.$rowSubtotal.'">';
            $body .= '<td style="'.$cellLeftAlignedSubtotal.'">'.$i18n->get('label.total').'</td>';
            if ($canViewReports || $isClient) $body .= '<td></td>';
            if ($report['show_client']) $body .= '<td></td>';
            if ($report['show_project']) $body .= '<td></td>';
            if ($report['show_task']) $body .= '<td></td>';
            if ($report['show_custom_field_1']) $body .= '<td></td>';
            if ($report['show_start']) $body .= '<td></td>';
            if ($report['show_end']) $body .= '<td></td>';
            if ($report['show_duration']) $body .= '<td style="'.$cellRightAlignedSubtotal.'">'.$totals['time'].'</td>';
            if ($report['show_note']) $body .= '<td></td>';
            if ($report['show_cost']) {
                $body .= '<td nowrap style="'.$cellRightAlignedSubtotal.'">'.htmlspecialchars($user->currency).' ';
                $body .= ($canViewReports || $isClient) ? $totals['cost'] : $totals['expenses'];
                $body .= '</td>';
            }
            if ($report['show_paid']) $body .= '<td></td>';
            if ($report['show_ip']) $body .= '<td></td>';
            if ($report['show_invoice']) $body .= '<td></td>';
            $body .= '</tr>';

            $body .= '</table>';
        }

        // Output footer.
        if (!defined('REPORT_FOOTER') || !(REPORT_FOOTER == false))
            $body .= '<p style="text-align: center;">'.$i18n->get('form.mail.footer').'</p>';

        // Finish creating email body.
        $body .= '</body></html>';

        return $body;
    }

    // sendFavReport - sends a favorite report to a specified email, called from cron.php
    static function sendFavReport($report, $subject, $email, $cc) {
        // We are called from cron.php, we have no $bean in session.
        // cron.php sets global $user and $i18n objects to match our favorite report user.
        global $user;
        global $i18n;

        // Prepare report body.
        $body = ttReportHelper::prepareFavReportBody($report);

        import('mail.Mailer');
        $mailer = new Mailer();
        $mailer->setCharSet(CHARSET);
        $mailer->setContentType('text/html');
        $mailer->setSender(SENDER);
        if (!empty($cc))
            $mailer->setReceiverCC($cc);
        if (!empty($user->bcc_email))
            $mailer->setReceiverBCC($user->bcc_email);
        $mailer->setReceiver($email);
        $mailer->setMailMode(MAIL_MODE);
        if (empty($subject)) $subject = $report['name'];
        if (!$mailer->send($subject, $body))
            return false;

        return true;
    }

    //MY HELPER FUNCTIONS .................................................................................................

    static function getWeekRange(){
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last monday midnight", $previous_week);
        $end_week = strtotime("next friday", $start_week);
        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);
        $start_week = date('Y-m-d', strtotime(str_replace('-', '/', $start_week)));
        $end_week = date('Y-m-d', strtotime(str_replace('-', '/', $end_week)));

        return array($start_week, $end_week);
    }

    static function getProjectUsers($usersId, $pArray, $logU){
        $projectsUsers = array();
        foreach ($pArray as $project) {
            $newArray = ttReportHelper::filterArrayByProjects($logU, $project['id']);
            $numberOfHoursOnProjectbyUsers = array();
            foreach ($usersId as $userid) {
                $dur = ttReportHelper::numberOfHoursonProjectbyUser($newArray, $userid['id']);
                array_push($numberOfHoursOnProjectbyUsers, $dur);
            }
            array_push($projectsUsers, $numberOfHoursOnProjectbyUsers);
        }
        return $projectsUsers;
    }

    static function getTotalTimebyUsers($usersId, $pArray, $projectsUsers){
        $totalTimebyUsers = array();
        for ($j = 0; $j < sizeof($usersId); $j++) {
            $x = 0;
            for ($i = 0; $i < sizeof($pArray); $i++) {
                $x += $projectsUsers[$i][$j];
            }
            array_push($totalTimebyUsers, $x);
        }
        return $totalTimebyUsers;
    }

    static function getTotalTimeinProjects($usersId, $pArray, $projectsUsers){
        $totalTimeinProject = array();
        for ($i = 0; $i < sizeof($pArray); $i++) {
            $x = 0;
            for ($j = 0; $j < sizeof($usersId); $j++) {
                $x += $projectsUsers[$i][$j];
            }
            array_push($totalTimeinProject, $x);
        }
        return $totalTimeinProject;
    }

    static function getDailyLoggingStatus($usersId, $groupedArray){
        $loggedEveryday = array();
        $dailyHours = array();

        foreach ($usersId as $userid) {
            $newArr = ttReportHelper::filterArrayByUsers($groupedArray, $userid['id']);
            $vals = array(false, false, false, false, false);
            $numbers = array(0, 0, 0, 0, 0);
            foreach ($newArr as $n) {
                $vals[date("w", strtotime($n['date'])) - 1] = true;
                $str_time = $n['total_duration'];
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $numbers[date("w", strtotime($n['date'])) - 1] = $time_seconds / 3600;
            }
            array_push($loggedEveryday, $vals);
            array_push($dailyHours, $numbers);
        }

        return array($loggedEveryday, $dailyHours);
    }

    static function getStatusReport($usersId, $dailyHours, $loggedEveryday, $totalTimebyUsers){
        $statusReport = array();

        for ($i = 0; $i < sizeof($usersId); $i++) {
            if (ttReportHelper::checkFalseReport($dailyHours[$i])) {
                $v = "Incorrect Report";
                array_push($statusReport, $v);
            } else if (!ttReportHelper::returnForFalse($loggedEveryday[$i])) {
                $v = "Missing Days";
                array_push($statusReport, $v);
            } else if ($totalTimebyUsers[$i] < 40) {
                $v = "Incomplete Hours";
                array_push($statusReport, $v);
            } else {
                $v = "Completed";
                array_push($statusReport, $v);
            }
        }
        return $statusReport;
    }

    static function getUserDateandDuration($logU){
        $userDateandDuration = array();
        foreach ($logU as $log) {
            $value = array(
                'name' => $log['u_name'],
                'date' => $log['date'],
                'duration' => $log['total_duration'],
                'project' => $log['name'],
                'task'  => $log['task_name']
            );

            array_push($userDateandDuration, $value);
        }
        return $userDateandDuration;
    }

    static function getMissingReportUsers($usersId, $statusReport){
        $arrayOfMissingReports = array();

        for ($i = 0; $i < sizeof($statusReport); $i++){
            if ($statusReport[$i] != "Completed"){
                array_push($arrayOfMissingReports, $usersId[$i]['login']);
            }
        }
        return $arrayOfMissingReports;
    }

    static function checkTypeOfReport($condition){
        $condition = str_replace('count', '', $condition);
        $count_required = (int) trim(str_replace('>', '', $condition));
        if ($count_required == 0){
            return true;
        }else {
            return false;
        }
    }

    static function checkFalseReport($array){
        foreach ($array as $a){
            if ($a > 24){
                return true;
            }
        }
        return false;
    }

    static function  returnForFalse($array){
        foreach($array as $a){
            if ($a == false){
                return false;
            }
        }
        return true;
    }

    static function filterArrayByProjects($array, $projectId){
        $newArray = array();
        foreach ($array as $i){
            if ($i['project_id'] == $projectId){
                array_push($newArray, $i);
            }
        }
        return $newArray;
    }
    static function filterArrayByUsers($array, $userId){
        $newArray = array();
        foreach ($array as $i){
            if ($i['user_id'] == $userId){
                array_push($newArray, $i);
            }
        }
        return $newArray;
    }

    static function numberOfHoursonProjectbyUser($array, $userid){
        $duration = 0;
        foreach ($array as $i){
            if ($i['user_id'] == $userid){
                $str_time = $i['total_duration'];
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $duration += $time_seconds;
            }
        }
        $hrsDuration = $duration / 3600;
        return $hrsDuration;
    }



    static function makeFile($filename, $numTimes ,$group_name, $usersId, $pArray, $projectUsers, $totalTimeByUsers, $totalTimeInProjects, $loggedEveryday, $dailyHours , $statusReport, $userDateAndDuration){
        $readers = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = NULL;
        $maxColumn = 'A';
        if ($numTimes > 0){
            $spreadsheet = $readers->load($filename.'.xlsx');
            $newSheet = new PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $group_name);
            $spreadsheet->addSheet($newSheet);
        }else{
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getActiveSheet()->setTitle($group_name);
        }

        $spreadsheet->setActiveSheetIndexByName($group_name);
        $sheet = $spreadsheet->getActiveSheet();


        $style = array(
            'alignment' => array(
                'horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            )
        );
        $spreadsheet->getDefaultStyle()->applyFromArray($style);

        //EXCEL FILE HEADER
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'Weekly Alert Driving Time Tracking Report');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        //DATE RANGE OF THE REPORT
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last monday midnight",$previous_week);
        $end_week = strtotime("next friday",$start_week);
        $start_week = date("M d Y",$start_week);
        $end_week = date("M d Y",$end_week);
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A2', $start_week.'-'.$end_week);

        //NAME OF THE GROUP
        $sheet->mergeCells('A3:L3');
        $sheet->setCellValue('A3', $group_name);
        $spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

        //USER AND PROJECT REPORT HEADER
        $sheet->mergeCells('A4:L4');
        $sheet->setCellValue('A4', 'User and Project Report: Summary of the contribution of each user to each project');

        $rowCounter = 6;
        $originalColumn = 'A';
        $columnCounter = 'A';

        //HEADER OF USER AND PROJECT TABLE
        $sheet->setCellValue($columnCounter.$rowCounter, 'User');
        $spreadsheet->getActiveSheet()->getColumnDimension($columnCounter)->setWidth(23);
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;

        //CODE TO SHOW PROJECTS IN THE WEEKLY REPORT:

//        for ($i = 0; $i < sizeof($pArray); $i++){
//            $sheet->setCellValue($columnCounter.$rowCounter, $pArray[$i]['name']);
//            $spreadsheet->getActiveSheet()->getColumnDimension($columnCounter)->setWidth(15);
//            $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
//            $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
//            $columnCounter++;
//        }

        $sheet->setCellValue($columnCounter.$rowCounter, 'Total Hours by User');
        $spreadsheet->getActiveSheet()->getColumnDimension($columnCounter)->setWidth(20);
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;

        $sheet->setCellValue($columnCounter.$rowCounter, 'Mon');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;

        $sheet->setCellValue($columnCounter.$rowCounter, 'Tues');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;
        $sheet->setCellValue($columnCounter.$rowCounter, 'Wed');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;
        $sheet->setCellValue($columnCounter.$rowCounter, 'Thurs');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;
        $sheet->setCellValue($columnCounter.$rowCounter, 'Fri');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
        $columnCounter++;
        $sheet->setCellValue($columnCounter.$rowCounter, 'Status of Report');
        $spreadsheet->getActiveSheet()->getColumnDimension($columnCounter)->setWidth(20);
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');

        $columnCounter = $originalColumn;
        $rowCounter++;

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                )
            )
        );


        //THE DATA FOR THE USER AND PROJECT REPORT.
        for($i = 0; $i < sizeof($usersId); $i++){
            $sheet->setCellValue($columnCounter.$rowCounter, $usersId[$i]['name']);
            $columnCounter++;

            //CODE TO SHOW PROJECTS IN THE WEEKLY REPORT:
//            for ($j = 0; $j < sizeof($pArray); $j++){
//                $sheet->setCellValue($columnCounter.$rowCounter, $projectUsers[$j][$i]);
//                $columnCounter++;
//            }



            $sheet->setCellValue($columnCounter.$rowCounter, $totalTimeByUsers[$i]);
            $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
            $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FF4500');
            $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray);
            $columnCounter++;

            for ($j = 0; $j < sizeof($loggedEveryday[$i]); $j++){
                if ($loggedEveryday[$i][$j]){
                    $sheet->setCellValue($columnCounter.$rowCounter, $dailyHours[$i][$j]);
                    $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
                    if ($dailyHours[$i][$j] < 24 && $dailyHours[$i][$j] > 0){
                        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('7CFC00');
                    }else{
                        $sheet->setCellValue($columnCounter.$rowCounter, $dailyHours[$i][$j]);
                        $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
                        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FFFFFF');
                        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('006400');
                    }
                }else{
                    $sheet->setCellValue($columnCounter.$rowCounter, $dailyHours[$i][$j]);
                    $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
                    $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000');
                }
                $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray);
                $columnCounter++;
            }
            $sheet->setCellValue($columnCounter.$rowCounter, $statusReport[$i]);


            $maxColumn = $columnCounter;

            $rowCounter++;
            $columnCounter = $originalColumn;
        }

        $sheet->setCellValue($columnCounter.$rowCounter, 'Total Hours on Project');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FF4500');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray);
        $columnCounter++;
        $totalSum = 0;

        //CODE TO SHOW PROJECTS IN THE WEEKLY REPORT:

        for ($i = 0; $i < sizeof($pArray); $i++){
//            $sheet->setCellValue($columnCounter.$rowCounter, $totalTimeInProjects[$i]);
            $totalSum += $totalTimeInProjects[$i];
//            $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
//            $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FF4500');
//            $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray);
//            $columnCounter++;
        }
        $sheet->setCellValue($columnCounter.$rowCounter, $totalSum);
        $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->getFont()->getColor()->setRGB('FF4500');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray);
        $columnCounter++;

        for ($i = 0; $i < 6; $i++){
            $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
            $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray);
            $columnCounter++;
        }

        $columnCounter = $originalColumn;
        $rowCounter += 2;

        $tmpcolumn = $columnCounter;
        $tmpcolumn++;
        $tmpcolumn++;
        $tmpcolumn++;


        //USER DATE AND TIME REPORT
        $sheet->mergeCells($columnCounter.$rowCounter.':'.$tmpcolumn.$rowCounter);
        $sheet->setCellValue($columnCounter.$rowCounter, 'User Date and Times Report');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);

        $rowCounter++;
        $columnCounter = $originalColumn;

        $sheet->setCellValue($columnCounter.$rowCounter, 'User');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $columnCounter++;
        $sheet->setCellValue($columnCounter.$rowCounter, 'Project');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $columnCounter++;

        $sheet->setCellValue($columnCounter.$rowCounter, 'Task');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $columnCounter++;

        $sheet->setCellValue($columnCounter.$rowCounter, 'Duration');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $columnCounter++;

        $sheet->setCellValue($columnCounter.$rowCounter, 'Date');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);




        $columnCounter = $originalColumn;
        $rowCounter++;

        $styleArray2 = array(
            'borders' => array(
                'top' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                )
            )
        );

        $tmpName = "";

        $isFirst = true;
        $subtotal = 0;

        foreach($userDateAndDuration as $u){

            if($isFirst){
                $isFirst = false;
            }else{
                if ($tmpName != $u['name']){
                    $sheet->setCellValue($columnCounter.$rowCounter,"Subtotal");
                    $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
                    $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
                    $columnCounter++;
                    $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
                    $columnCounter++;
                    $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
                    $columnCounter++;
                    $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
                    $sheet->setCellValue($columnCounter.$rowCounter,$subtotal);
                    $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
                    $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
                    $columnCounter++;
                    $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
                    $subtotal = 0;
                    $rowCounter++;
                    $columnCounter = $originalColumn;
                }
            }

            if ($tmpName != $u['name']){
                $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray2);
                $sheet->setCellValue($columnCounter.$rowCounter, $u['name']);
            }
            $columnCounter++;
            if ($tmpName != $u['name']){
                $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray2);
            }
            $sheet->setCellValue($columnCounter.$rowCounter, $u['project']);
            $columnCounter++;

            if ($tmpName != $u['name']){
                $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray2);
            }
            if ($u['task'] != null){
                $sheet->setCellValue($columnCounter.$rowCounter, $u['task']);
            }else{
                $sheet->setCellValue($columnCounter.$rowCounter, "-");
            }
            $columnCounter++;

            if ($tmpName != $u['name']){
                $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray2);
            }
            $str_time = $u['duration'];
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $sheet->setCellValue($columnCounter.$rowCounter, $time_seconds/3600);
            $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
            $subtotal += $time_seconds/3600;
            $columnCounter++;

            if ($tmpName != $u['name']){
                $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray2);
            }
            $sheet->setCellValue($columnCounter.$rowCounter, date("M-d-Y", strtotime($u['date'])));
            $rowCounter++;
            $columnCounter = $originalColumn;

            $tmpName = $u['name'];
        }

        $styleArray3 = array(
            'borders' => array(
                'bottom' => array(
                    'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                )
            )
        );

        $sheet->setCellValue($columnCounter.$rowCounter,"Subtotal");
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;


        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;

        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;

        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->setCellValue($columnCounter.$rowCounter,$subtotal);
        $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;

        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $subtotal = 0;
        $rowCounter += 2;
        $columnCounter = $originalColumn;

        $tmpcolumn = $columnCounter;
        $tmpcolumn++;
        $sheet->mergeCells($columnCounter.$rowCounter.':'.$tmpcolumn.$rowCounter);
        $sheet->setCellValue($columnCounter.$rowCounter, 'Total Project Hours Report');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $rowCounter++;
        $columnCounter = $originalColumn;

        $sheet->setCellValue($columnCounter.$rowCounter, 'Project');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;
        $sheet->setCellValue($columnCounter.$rowCounter, 'Total Hours');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter = $originalColumn;
        $rowCounter++;

        for ($i = 0; $i < sizeof($pArray); $i++){
            $sheet->setCellValue($columnCounter.$rowCounter, $pArray[$i]['name']);
            $columnCounter++;
            $sheet->setCellValue($columnCounter.$rowCounter, $totalTimeInProjects[$i]);
            $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
            $columnCounter = $originalColumn;
            $rowCounter++;
        }

        $sheet->setCellValue($columnCounter.$rowCounter,"Total Hours in Projects");
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;

        $sheet->getStyle($columnCounter.$rowCounter)->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $sheet->setCellValue($columnCounter.$rowCounter,$totalSum);
        $sheet->getStyle($columnCounter.$rowCounter)->getNumberFormat()->setFormatCode('0.00');
        $spreadsheet->getActiveSheet()->getStyle($columnCounter.$rowCounter)->getFont()->setBold(true);
        $sheet->getStyle($columnCounter.$rowCounter)->applyFromArray($styleArray3);
        $columnCounter++;


        for ($col = $originalColumn; $col !== $maxColumn; $col++){
            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }


        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filename.'.xlsx');
        return true;
    }

    static function groupReportGenerator($val){
        $mdb2 = getConnection();
        //Get the group id
        $group_id = $val['group_id'];
        $group_name = $val['group_name'];

        //SQL Query on the Users table to get all users of the group
        $sql = "select u.id, u.name, u.login from tt_users u where u.group_id = $group_id";
        $ures = $mdb2->query($sql);
        if (is_a($ures, 'PEAR_Error')) {
            exit();
        }
        //usersId: contains the data of all users in the group.
        $usersId = array();
        while ($vval = $ures->fetchRow()) {
            array_push($usersId, $vval);
        }

        list($start_week, $end_week) = ttReportHelper::getWeekRange();

        //SQL query used to find all the logs within the previous week, sorted by user id and grouped by project id, date and user id.
        $sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(l.duration))) As total_duration, l.user_id, u.login, u.name as u_name, l.date ,l.project_id, l.task_id, p.name, t.name AS task_name from tt_log l 
            left join tt_users u on (l.user_id = u.id) 
            left join tt_projects p on (l.project_id = p.id)
            left join tt_tasks t on (l.task_id = t.id) 
            where l.date <= '$end_week' AND l.date >= '$start_week' AND u.group_id = $group_id  AND WEEKDAY(l.date) < 5 AND l.status = 1
            GROUP BY l.user_id, l.project_id, l.date, l.task_id
            ORDER BY l.user_id, l.date";

        $tres = $mdb2->query($sql);
        if (is_a($tres, 'PEAR_Error')) exit();
        //logU: contains all the logs from the group users within the timeline of previous week's monday to friday.
        $logU = array();

        while ($dval = $tres->fetchRow()) {
            array_push($logU, $dval);
        }

        //SQL Query on the Projects table to get all the projects worked on by the group.
        $sql = "select distinct project_id as id, p.name
                from tt_log l
                left join tt_projects p on (p.id = project_id)
                where l.date <= '$end_week' AND l.date >= '$start_week' AND p.group_id = $group_id  AND WEEKDAY(l.date) < 5 AND l.status = 1;";

        $pres = $mdb2->query($sql);
        if (is_a($pres, 'PEAR_Error')) exit();
        //pArray: contains all the projects being worked on by the group.
        $pArray = array();
        while ($pval = $pres->fetchRow()) {
            array_push($pArray, $pval);
        }

        //projectUsers: 2D array with the number of hours spent by each user on each project.
        //totalTimebyUsers: 1D array of the total time spent on each User in the week.
        //totalTimeinProjects: 1D array of the total time spent by the users on each project in the week.
        $projectsUsers = ttReportHelper::getProjectUsers($usersId, $pArray, $logU);
        $totalTimebyUsers = ttReportHelper::getTotalTimebyUsers($usersId, $pArray, $projectsUsers);
        $totalTimeinProject = ttReportHelper::getTotalTimeinProjects($usersId, $pArray, $projectsUsers);

        //SQL query used to find all the logs within the previous week, sorted by user id and date.
        $sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(l.duration))) As total_duration, l.user_id, u.login, l.date ,l.project_id, p.name from tt_log l 
            left join tt_users u on (l.user_id = u.id) 
            left join tt_projects p on (l.project_id = p.id)
           where l.date <= '$end_week' AND l.date >= '$start_week' AND u.group_id = $group_id  AND WEEKDAY(l.date) < 5 AND l.status = 1
            GROUP BY l.user_id, l.date
            ORDER BY l.user_id";

        $fres = $mdb2->query($sql);
        if (is_a($fres, 'PEAR_Error')) exit();

        $groupedArray = array();
        while ($fval = $fres->fetchRow()) {
            array_push($groupedArray, $fval);
        }

        list ($loggedEveryday, $dailyHours) = ttReportHelper::getDailyLoggingStatus($usersId, $groupedArray);
        $statusReport = ttReportHelper::getStatusReport($usersId, $dailyHours, $loggedEveryday, $totalTimebyUsers);

        // usersId : array of users in the Group
        // pArray: array of projects in the Group
        // logU: array of logs by the users of the group
        //projectsUsers: 2D array of Projects vs number of Users spend working by users.
        //totalTimebyUsers: array with the project timings of all the users.
        //totalTimeinProjects: array with the total time spent in each project.
        //loggedEveryday: 2D array of all users for 5 days in a week with attendance per week.
        //dailyHours: 2D array of the number of hours worked per days by each user
        //statusReport: array with Completed, Missing Days and Incomplete Hours values parallel to the users array.
        //userDateandDuration: associative array with the name, duration, date and project update of the user.

        $userDateandDuration = ttReportHelper::getUserDateandDuration($logU);
        $arrayOfMissingReports = ttReportHelper::getMissingReportUsers($usersId, $statusReport);


        return array($usersId, $pArray, $logU, $projectsUsers, $totalTimebyUsers, $totalTimeinProject, $loggedEveryday,  $dailyHours, $statusReport, $userDateandDuration, $arrayOfMissingReports);
    }

    static function reportGenerator($res, $copyRes = false, $filename="Weekly-Report", $numTimes = 0){
        global $i18n;
        $mdb2 = getConnection();
        $now = time();

        $email = "";
        while ($val = $res->fetchRow()) {

            $email = $val['email'];
            // We have jobs to execute in user language.
            // Get favorite report details.
            $report = ttFavReportHelper::getReport($val['report_id']);
            if (!$report) continue; // Skip not found report.

            // Recycle global $user object, as user settings are specific for each report.
            $user = new ttUser(null, $report['user_id']);
            if (!$user->id) continue; // Skip not found user.

            //--------------------------------------------------------------------------------------------------------------------------------------------------------------
            //New added code to the open source
            //--------------------------------------------------------------------------------------------------------------------------------------------------------------

            list ($usersId, $pArray, $logU,
                $projectsUsers, $totalTimebyUsers,
                $totalTimeinProject, $loggedEveryday,
                $dailyHours, $statusReport,
                $userDateandDuration, $arrayOfMissingReports) = ttReportHelper::groupReportGenerator($val);

            //Get the group id
            $group_id = $val['group_id'];
            $group_name = $val['group_name'];

            // Recycle $i18n object because language is user-specific.
            $i18n->load($user->lang);


            // Email report if condition is okay.

            if (ttReportHelper::checkTypeOfReport($val['report_condition'])) {
                if (ttReportHelper::makeFile($filename, $numTimes, $group_name, $usersId, $pArray, $projectsUsers, $totalTimebyUsers, $totalTimeinProject, $loggedEveryday, $dailyHours, $statusReport, $userDateandDuration)) {
                    $numTimes++;
                    $copyRes = true;
                    echo "Created Excel file <br>";
                } else {
                    echo "Error creating the excel file... <br>";
                }
            }else{
                foreach($arrayOfMissingReports as $a){
                    if (EmailSender::sendReminder($a)){
                        echo "email sent successfully to " . $a . "<br>";
                    }else{
                        echo "email failed to send to ". $a. "<br>";
                    }
                }
            }

            // Calculate next execution time.
            $next = tdCron::getNextOccurrence($val['cron_spec'], $now + 60); // +60 sec is here to get us correct $next when $now is close to existing "next".
            // This is because the accuracy of tdcron class appears to be 1 minute.
            // Update last and next values in tt_cron.
            $sql = "update tt_cron set last = $now, next = $next where id = " . $val['id'];
            $affected = $mdb2->exec($sql);
            if (is_a($affected, 'PEAR_Error')) continue;
        }


        if ($copyRes) {
            if (EmailSender::sendFile($filename, $email)) {
                echo "Excel file sent successsfully <br>";
            } else {
                echo "Error sending the excel file <br>";
            }
        }
        return true;
    }
}
