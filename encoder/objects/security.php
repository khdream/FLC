<?php

require_once $global['systemRootPath'] . 'objects/functions.php';
// filter some security here
$securityFilter = array('error', 'catName', 'type', 'channelName', 'captcha', 'showOnly', 'key', 'link', 'email', 'country', 'region');
$securityFilterInt = array('videos_id', 'video_id', 'categories_id', 'user_id', 'users_id', 'comments_id', 'usergroups_id');
$securityRemoveSingleQuotes = array('search', 'searchPhrase', 'videoName');
$securityRemoveNonChars = array('resolution', 'format', 'videoDirectory');


if (!empty($_GET['base64Url'])) {
    if (!filter_var(base64_decode($_GET['base64Url']), FILTER_VALIDATE_URL)) {
        error_log('base64Url attack ' . json_encode($_SERVER));
        exit;
    }
}

if (!empty($_FILES['video']['name'])) {
    $_FILES['video']['name'] = preg_replace('/[^a-z0-9.]/i', '', $_FILES['video']['name']);
}

foreach ($securityRemoveNonChars as $value) {
    if (!empty($_POST[$value])) {
        if (is_string($_POST[$value])) {
            $_POST[$value] = str_replace('/[^a-z0-9./]/i', '', trim($_POST[$value]));
        } else if (is_array($_POST[$value])) {
            foreach ($_POST[$value] as $key => $value) {
                if (is_string($_POST[$value][$key])) {
                    $_POST[$value][$key] = str_replace('/[^a-z0-9./]/i', '', trim($_POST[$value][$key]));
                }
            }
        }
    }
    if (!empty($_GET[$value])) {
        if (is_string($_GET[$value])) {
            $_GET[$value] = str_replace('/[^a-z0-9./]/i', '', trim($_GET[$value]));
        } else if (is_array($_GET[$value])) {
            foreach ($_GET[$value] as $key => $value) {
                if (is_string($_GET[$value][$key])) {
                    $_GET[$value][$key] = str_replace('/[^a-z0-9./]/i', '', trim($_GET[$value][$key]));
                }
            }
        }
    }
}

foreach ($securityRemoveSingleQuotes as $value) {
    if (!empty($_POST[$value])) {
        if (is_string($_POST[$value])) {
            $_POST[$value] = str_replace("'", "", trim($_POST[$value]));
        } else if (is_array($_POST[$value])) {
            foreach ($_POST[$value] as $key => $value) {
                if (is_string($_POST[$value][$key])) {
                    $_POST[$value][$key] = str_replace("'", "", trim($_POST[$value][$key]));
                }
            }
        }
    }
    if (!empty($_GET[$value])) {
        if (is_string($_GET[$value])) {
            $_GET[$value] = str_replace("'", "", trim($_GET[$value]));
        } else if (is_array($_GET[$value])) {
            foreach ($_GET[$value] as $key => $value) {
                if (is_string($_GET[$value][$key])) {
                    $_GET[$value][$key] = str_replace("'", "", trim($_GET[$value][$key]));
                }
            }
        }
    }
}

foreach ($securityFilterInt as $value) {
    if (!empty($_POST[$value])) {
        if (is_string($_POST[$value])) {
            $_POST[$value] = intval($_POST[$value]);
        } else if (is_array($_POST[$value])) {
            foreach ($_POST[$value] as $key => $value) {
                if (is_string($_POST[$value][$key])) {
                    $_POST[$value][$key] = intval($_POST[$value]);
                }
            }
        }
    }
    if (!empty($_GET[$value])) {
        if (is_string($_GET[$value])) {
            $_GET[$value] = intval($_GET[$value]);
        } else if (is_array($_GET[$value])) {
            foreach ($_GET[$value] as $key => $value) {
                if (is_string($_GET[$value][$key])) {
                    $_GET[$value][$key] = intval($_GET[$value]);
                }
            }
        }
    }
}

foreach ($securityFilter as $value) {
    if (!empty($_POST[$value])) {
        $_POST[$value] = str_replace(array("'", '"', "&quot;", "&#039;"), array('', '', '', ''), xss_esc($_POST[$value]));
    }
    if (!empty($_GET[$value])) {
        $_GET[$value] = str_replace(array("'", '"', "&quot;", "&#039;"), array('', '', '', ''), xss_esc($_GET[$value]));
    }
}

if (!empty($_GET['sort']) && is_array($_GET['sort'])) {
    foreach ($_GET['sort'] as $key => $value) {
        $_GET['sort'][xss_esc($key)] = strcasecmp($value, "ASC") === 0 ? "ASC" : "DESC";
    }
}
if (!empty($_POST['sort']) && is_array($_POST['sort'])) {
    foreach ($_POST['sort'] as $key => $value) {
        $_POST['sort'][xss_esc($key)] = strcasecmp($value, "ASC") === 0 ? "ASC" : "DESC";
    }
}