<?php
    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }

    function flash($name = '', $message = '', $class = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4'){
        if(!empty($name)){
            if(!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }
                if(!empty($_SESSION[$name . '_class'])){
                    unset($_SESSION[$name . '_class']);
                }
                $_SESSION[$name] = $message;
                $_SESSION[$name . '_class'] = $class;
            } elseif(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4';
                $strong_text = (strpos($class, 'red') !== false || strpos($class, 'yellow') !== false) ? 'Lỗi!' : 'Thành công!';
                echo '<div class="' . $class . '" role="alert">';
                echo '<strong class="font-bold">' . $strong_text . '</strong>';
                echo '<span class="block sm:inline"> ' . $_SESSION[$name] . '</span>';
                echo '</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name . '_class']);
            }
        }
    }