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

/*
 * cron.php - this file is an entry point to execute scheduled jobs in Time Tracker.
 * It must be called externally (for example, from the system cron or task scheduler).
 * 
 * Internally, we store scheduled jobs in tt_cron table in db. The cron_spec field is in cron format.
 * Along with it, we store last and next timestamps for jobs, we use them as an execute condition.
 * 
 * Although cron_spec follows 5-field cron specification precisely, actual job timing depends on
 * how often cron.php is called. For example, an hourly ping will execute jobs no more than once
 * each hour, even if they are due more often. Configure whatever calls this file accordingly.
 */

require_once('initialize.php');
require_once(LIBRARY_DIR . '/tdcron/class.tdcron.php');
require_once(LIBRARY_DIR . '/tdcron/class.tdcron.entry.php');
import('ttFavReportHelper');
import('ttReportHelper');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$mdb2 = getConnection();
$now = time();

$sql = "select c.id, c.cron_spec, c.report_id, c.email, c.cc, c.subject, c.report_condition, c.group_id, gr.name as group_name from tt_cron c
   left join tt_fav_reports fr on (c.report_id = fr.id)
   left join tt_groups gr on (c.group_id = gr.id)
   where $now >= c.next and fr.status = 1
   and c.status = 1 and c.report_id is not null and c.email is not null";
$res = $mdb2->query($sql);
if (is_a($res, 'PEAR_Error'))
    exit();


$copyRes = false;

//
//
//$spreadsheet = new Spreadsheet();
//
//$writer = new Xlsx($spreadsheet);
$filename = "Weekly-Report";
$numTimes = 0;
//$writer->save($filename.'.xlsx');

while ($val = $res->fetchRow()) {

    $copyRes = true;
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

    //Get the group id
    $group_id = $val['group_id'];
    $group_name = $val['group_name'];


    //get all the users in the group.
    $sql = "select u.id, u.name, u.login from tt_users u where u.group_id = $group_id";
    $ures = $mdb2->query($sql);
    if (is_a($ures, 'PEAR_Error')) {
        continue;
    }
    $usersId = array();
    while ($vval = $ures->fetchRow()) {
        array_push($usersId, $vval);
    }

    $previous_week = strtotime("-1 week +1 day");
    $start_week = strtotime("last monday midnight", $previous_week);
    $end_week = strtotime("next friday", $start_week);
    $start_week = date("Y-m-d", $start_week);
    $end_week = date("Y-m-d", $end_week);
    $start_week = date('Y-m-d', strtotime(str_replace('-', '/', $start_week)));
    $end_week = date('Y-m-d', strtotime(str_replace('-', '/', $end_week)));

    //SQL query used to find all the logs within the previous week, sorted by user id and grouped by project id, date and user id.

    $sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(l.duration))) As total_duration, l.user_id, u.login, u.name as u_name, l.date ,l.project_id, p.name from tt_log l 
            left join tt_users u on (l.user_id = u.id) 
            left join tt_projects p on (l.project_id = p.id)
            where l.date <= '$end_week' AND l.date >= '$start_week' AND u.group_id = $group_id  AND WEEKDAY(l.date) < 5
            GROUP BY l.user_id, l.project_id, l.date
            ORDER BY l.user_id, l.date";

    $tres = $mdb2->query($sql);
    if (is_a($tres, 'PEAR_Error')) continue;

    $logU = array();

    while ($dval = $tres->fetchRow()) {
        array_push($logU, $dval);
    }

    $projectsUsers = array();

    //Get all the projects in the group.
    $sql = "select p.id, p.name from tt_projects p where group_id = $group_id";
    $pres = $mdb2->query($sql);
    if (is_a($pres, 'PEAR_Error')) continue;

    $pArray = array();
    while ($pval = $pres->fetchRow()) {
        array_push($pArray, $pval);
    }

    // usersId : array of users in the Group
    // pArray: array of projects in the Group
    // logU: array of logs by the users of the group

    foreach ($pArray as $project) {
        $newArray = ttReportHelper::filterArrayByProjects($logU, $project['id']);
        $numberOfHoursOnProjectbyUsers = array();
        foreach ($usersId as $userid) {
            $dur = ttReportHelper::numberOfHoursonProjectbyUser($newArray, $userid['id']);
            array_push($numberOfHoursOnProjectbyUsers, $dur);
        }
        array_push($projectsUsers, $numberOfHoursOnProjectbyUsers);
    }

//    for ($i = 0; $i < sizeof($pArray); $i++){
//        echo "For project: " . $pArray[$i]['name']."<br>";
//        for($j = 0; $j < sizeof($usersId); $j++){
//            echo "User " . $usersId[$j]['name'] . ": " . $projectsUsers[$i][$j] ."<br>";
//        }
//    }

    $totalTimebyUsers = array();
    $totalTimeinProject = array();
    for ($j = 0; $j < sizeof($usersId); $j++) {
        $x = 0;
        for ($i = 0; $i < sizeof($pArray); $i++) {
            $x += $projectsUsers[$i][$j];
        }
        array_push($totalTimebyUsers, $x);
    }

    for ($i = 0; $i < sizeof($pArray); $i++) {
        $x = 0;
        for ($j = 0; $j < sizeof($usersId); $j++) {
            $x += $projectsUsers[$i][$j];
        }
        array_push($totalTimeinProject, $x);
    }

//    echo json_encode($totalTimebyUsers). "<br>";
//    echo json_encode($totalTimeinProject). "<br>";

    $sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(l.duration))) As total_duration, l.user_id, u.login, l.date ,l.project_id, p.name from tt_log l 
            left join tt_users u on (l.user_id = u.id) 
            left join tt_projects p on (l.project_id = p.id)
           where l.date <= '$end_week' AND l.date >= '$start_week' AND u.group_id = $group_id  AND WEEKDAY(l.date) < 5
            GROUP BY l.user_id, l.date
            ORDER BY l.user_id";

    $fres = $mdb2->query($sql);
    if (is_a($fres, 'PEAR_Error')) continue;

    $groupedArray = array();
    while ($fval = $fres->fetchRow()) {
        array_push($groupedArray, $fval);
    }

//    echo json_encode($groupedArray)."<br>";
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
//    echo json_encode($loggedEveryday). "<br>";
//    echo json_encode($dailyHours)."<br>";

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
//    echo json_encode($statusReport) . "<br>";

    $userDateandDuration = array();
    foreach ($logU as $log) {
        $value = array(
            'name' => $log['u_name'],
            'date' => $log['date'],
            'duration' => $log['total_duration'],
            'project' => $log['name']
        );

        array_push($userDateandDuration, $value);
    }

    foreach ($userDateandDuration as $u) {
        $secs = strtotime($u['duration']) - strtotime("00:00:00");
        echo $u['name'] . " " . date("M-d-Y", strtotime($u['date'])) . " " . $secs / 3600 . " " . $u['project'] . " <br>";
    }

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


    // Recycle $i18n object because language is user-specific.
    $i18n->load($user->lang);

    // Check condition on a report.
    $condition_ok = true;
    if ($val['report_condition']) {
        $condition_ok = ttReportHelper::checkFavReportCondition($report, $val['report_condition']);
    }

    // Email report if condition is okay.
    if ($condition_ok) {
        if (ttReportHelper::sendFavReport($report, $val['subject'], $val['email'], $val['cc']))
            echo "Report " . $val['report_id'] . " sent.<br>";
        else
            echo "Error while emailing report...<br>";

        if (ttReportHelper::makeFile($filename, $numTimes, $group_name, $usersId, $pArray, $projectsUsers, $totalTimebyUsers, $totalTimeinProject, $loggedEveryday, $dailyHours, $statusReport, $userDateandDuration)) {
            $numTimes++;
            echo "Created Excel file <br>";
        } else {
            echo "Error creating the excel file... <br>";
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
    if (ttReportHelper::sendFile($filename, "pratik.choudhary@alertdriving.com")) {
        echo "Excel file sent successsfully <br>";
    } else {
        echo "Error sending the excel file <br>";
    }
}


echo "Done!";
