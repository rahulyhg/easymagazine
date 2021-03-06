<?php

/*
    Copyright (C) 2009-2012  Fabio Mattei <burattino@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

define('STARTPATH', '../../../');

require_once(STARTPATH.'costants.php');
require_once(STARTPATH.SYSTEMPATH.'config.php');
require_once(STARTPATH.DBPATH.'db.php');
require_once(STARTPATH.DATAMODELPATH.'user.php');
require_once(STARTPATH.CONTROLLERPATH.'all_controllers_commons.php');
require_once(STARTPATH.UTILSPATH.'directoryrunner.php');


session_start();
AllControllersCommons::loadlanguage();

function index() {
    $out = array();

    $userp = new User();
    $out['userp'] = $userp;

    $userps = User::findAll();
    $out['userps'] = $userps;

    return $out;
}

function edit($id) {
    $out = array();

    $userp = User::findById($id);
    $out['userp'] = $userp;

    $userps = User::findAll();
    $out['userps'] = $userps;

    return $out;
}

function requestdelete($id) {
    $out = array();

    $userp = User::findById($id);
    $out['userp'] = $userp;

    $userps = User::findAll();
    $out['userps'] = $userps;

    $out['question'] = LANG_CON_USER_DO_YOU_WANT_DELETE.$userp->getName().' - '.$userp->getUsername().'? <br />
    <a href="user.php?action=dodelete&id='.$userp->getId().'">'.LANG_CON_GENERAL_YES.'</a>,
    <a href="user.php">'.LANG_CON_GENERAL_NO.'</a>';

    return $out;
}

function dodelete($id) {
    $out = array();

    $userp = User::findById($id);
    $userp->delete();
    $userp = new User();
    $out['userp'] = $userp;

    $userps = User::findAll();
    $out['userps'] = $userps;

    $out['info'] = LANG_CON_USER_DELETED;

    return $out;
}

function save($toSave) {
    $out = array();

    if (!isset($toSave['toshow'])) { $toSave['toshow'] = 0; }

    # If the user is published I need to delete the cache
    if ($toSave['toshow'] == 1) {
        DirectoryRunner::cleanDir('cached');
    }

    $checkusername = User::findByUserName($toSave['Username']);

    $userp = new User(
        $toSave['id'],
        $toSave['Name'],
        $toSave['Username'],
        $toSave['Password'],
        $toSave['Body'],
        $toSave['Role'],
        $toSave['toshow'],
        $toSave['Email'],
        $toSave['MSN'],
        $toSave['Skype'],
        $toSave['created'],
        $toSave['updated']);

    if ($checkusername->getId() == User::NEW_USER) {
        // There is no user with the same username so I can save the user
        $userp->save();
        $userp->updateUsername($toSave['Username']);

        $out['info'] = LANG_CON_USER_SAVED;
    } elseif ($checkusername->getId() == $toSave['id']) {
        // The user didn't change the username
        $userp->save();

        $out['info'] = LANG_CON_USER_SAVED;
    } else {
        $out['error'] = LANG_CON_USER_WITH_SAME_USERNAME;
    }

    $userp = User::findById($userp->getId()); // Necessary to reload date informations

    $out['userp'] = $userp;

    $userps = User::findAll();
    $out['userps'] = $userps;

    return $out;
}

function savePassword($toSave) {
    $out = array();

    $userp = User::findById($toSave['id']);

    if ($toSave['NewPassword1'] == $toSave['NewPassword2']) {
        $userp->updatePassword($toSave['NewPassword1'], $toSave['OldPassword']);
        $out['info'] = LANG_CON_USER_PASSWORD_MODIFIED;
    } else {
        $out['error'] = LANG_CON_USER_PASSWORD_NO_MACH;
    }

    $out['userp'] = User::findById($userp->getId());

    $userps = User::findAll();
    $out['userps'] = $userps;

    return $out;
}

if (isset($_SESSION['user'])) {

    if (isset($_GET['action'])) { $action = $_GET['action']; }
    else { $action = 'index'; }

    if (isset($_SESSION['user'])) {
        switch ($action) {
            case  'index':         $out = index(); break;
            case  'save':          $out = save($_POST); break;
            case  'savePassword':  $out = savePassword($_POST); break;
            case  'edit':          $out = edit($_GET['id']); break;
            case  'dodelete':      $out = dodelete($_GET['id']); break;
            case  'requestdelete': $out = requestdelete($_GET['id']); break;
        }
    }
    
} else {
    header("Location: ../../loginError.php");
}

$userps = $out['userps'];
$userp = $out['userp'];

$infoarray = array();
$warningarray = array();
$questionarray = array();
$errorarray = array();

if (isset($out['info'])) { $infoarray[] = $out['info']; }
if (isset($out['warning'])) { $warningarray[] = $out['warning']; }
if (isset($out['question'])) { $questionarray[] = $out['question']; }
if (isset($out['error'])) { $errorarray[] = $out['error']; }

include('../../view/publisher/users.php');

?>
