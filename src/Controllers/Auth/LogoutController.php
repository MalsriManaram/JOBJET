<?php

session_start();
session_unset();
session_destroy();
header('location:'.BASE_URL.'home');
