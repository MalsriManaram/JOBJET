<?php

// Load Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

// Load custom path definitions
require_once __DIR__.'/../path.php';

// Parse and strip base path for clean routing
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($scriptName);

// Default to the whole URI path
$request = $uri;

// Strip base_path if it matches
if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
    $request = substr($uri, strlen($basePath));
}

// Normalize and clean request
$request = trim($request, '/');
if ($request === '' || $request === 'index.php') {
    $request = 'home';
}

// Set current_page (strip .php if accidentally included in URL)
$current_page = $request;
$current_page = str_replace('.php', '', $current_page);
// If requests like 'auth/login' should map to 'login' for current_page
if (str_starts_with($current_page, 'auth/')) {
    $current_page = str_replace('auth/', '', $current_page);
}

// Routing: Map URLs to the correct files
switch ($request) {
    // Main pages
    case 'home':
        require SRC.'Views/pages/home.php';
        break;
    case 'top_employers':
        require SRC.'Views/pages/top_employers.php';
        break;
    case 'find_people':
        require SRC.'Views/pages/find_people.php';
        break;
    case 'cv_genarator':
        require SRC.'Views/pages/cv_genarator.php';
        break;
    case 'aboutus':
        require SRC.'Views/pages/aboutus.php';
        break;
    case 'contactus':
        require SRC.'Views/pages/contactus.php';
        break;

        // Profile related pages
    case 'profile/my_profile':
        require SRC.'Views/pages/Profile/my_profile.php';
        break;
    case 'profile/edit_profile':
        require SRC.'Views/pages/Profile/edit_profile.php';
        break;
    case 'profile/view_profile':
        require SRC.'Views/pages/Profile/view_profile.php';
        break;
    case 'profile/view_resume':
        require SRC.'Views/pages/Profile/view_resume.php';
        break;
    case 'profile/view_my_resume':
        require SRC.'Views/pages/Profile/view_my_resume.php';
        break;

        // Job related pages
    case 'jobs':
        require SRC.'Views/pages/jobs.php';
        break;
    case 'job_search':
        require SRC.'Views/pages/job_search.php';
        break;
    case 'apply_job':
        require SRC.'Views/pages/apply_job.php';
        break;

        // Auth pages
    case 'auth/login':
        require SRC.'Views/pages/Auth/login.php';
        break;
    case 'auth/signup':
        require SRC.'Views/pages/Auth/signup.php';
        break;
    case 'auth/forgot-password':
        require SRC.'Views/pages/Auth/forgot-password.php';
        break;
    case 'auth/change-password':
        require SRC.'Views/pages/Auth/change-password.php';
        break;
    case 'auth/LogoutController':
        require SRC.'Controllers/Auth/LogoutController.php';
        break;

        // default route for unmatched URLs
    default:
        // 404 Not Found
        http_response_code(404);
        $page_title = '404 - Not Found';
        require LAYOUTS.'header.php';
        require PAGES.'404.php';
        break;
}
