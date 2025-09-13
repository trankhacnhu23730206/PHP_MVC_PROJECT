<?php
    function redirect($page){
        header('location: ' . URLROOT . '/public/' . $page);
    }
