<?php

if (!function_exists('hasPermission')) {
    function hasPermission($controller, $method) {
        $data = get_instance()->session->userdata('admin_session');
        if ($data->role == 1) {
            return TRUE;
        } else {
            $permissions= get_instance()->config->item('admin_session');
            if (is_array($permissions) && array_key_exists($controller, $permissions) && in_array($method, $permissions[$controller])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}

if (!function_exists('printPermission')) {
    function printPermission($key, $array, $parent_key, $given_permission) {
        $str = '';
        $name = NULL;
        if (!is_null($parent_key)) {
            $name = 'name="perm[' . $parent_key . '][]"';
            if (is_array($given_permission) && array_key_exists($parent_key, $given_permission) && in_array($key, $given_permission[$parent_key])) {
                $str = ' checked="checked"';
            }
        } else {
            if (is_array($given_permission) && array_key_exists($key, $given_permission)) {
                $str = ' checked="checked"';
            }
        }


        foreach ($array as $k => $v) {
            if ($k != 'hasChild') {
                if (array_key_exists('type', $array)) {
                    $type = $array['type'];
                } else {
                    $type = 'checkbox';
                }



                if (array_key_exists('key', $array)) {
                    $name = 'name = "perm' . strip_quotes($array['key']) . '" ';

                    $v3 = 'given_permission' . $array['key'];
                    $check = eval('return isset($' . $v3 . ');');

                    if ($check) {
                        if ($type == 'checkbox') {
                            $str = ' checked="checked"';
                        } else {
                            if (eval('return $' . $v3 . ';') == $key) {
                                $str = ' checked="checked"';
                            }
                        }
                    }
                }

                if($type == 'checkbox'){
                    $class = 'class="icheckbox_square-grey"';
                } else {
                    $class = 'class="iradio_square-grey"';
                }


                return '<li><input type="' . $type . '" value="' . $key . '"' . $name . $str . $class . '/><span>&nbsp;' . $v . '</span>';
            } else {
                break;
            }
        }
    }
}

if (!function_exists('loopPermissionArray')) {
    function loopPermissionArray($array, $given_permission = null, $parent_key = null) {
        foreach ($array as $key => $value) {
            if (isset($value['hasChild'])) {
                echo printPermission($key, $value, $parent_key, $given_permission), '<ul>';
                $key = array_key_exists('key', $value['hasChild']) ? $value['hasChild']['key'] : $key;
                loopPermissionArray($value['hasChild'], $given_permission, $key);
                echo '</ul>';
            } else {
                echo printPermission($key, $value, $parent_key, $given_permission);
            }
        }
    }
}

if (!function_exists('createPermissionArray')) {
    function createPermissionArray() {
        $CI =& get_instance();
        $permission = array(
            'roles' => array(
                'name' => 'Roles',
                'hasChild' => array(
                    'viewRole' => array('name' => 'List'),
                    'addRole' => array('name' => 'Add'),
                    'editRole' => array('name' => 'Edit'),
                    'deleteRole' => array('name' => 'Delete'),
                )
            ),
            'systemsettings' => array(
                'name' => 'System Setting',
                'hasChild' => array(
                    'viewSystemSetting' => array('name' => 'Edit')
                )
            )
        );
        return $permission;
    }
}

?>
