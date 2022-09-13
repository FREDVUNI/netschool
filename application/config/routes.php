<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*api routes*/
$route['student/login']="api/Authentication/login";
$route['student/register']="api/Authentication/registration";
/*api routes*/

/*backend routes*/
$route['admin/login'] = 'backend/Auth/index';
$route['admin/forgot-password'] = 'backend/Auth/forgotpassword';
$route['admin/reset-password']="backend/Auth/resetpassword";
$route['admin/auth/change-password'] = 'backend/Auth/changePassword';
$route['admin/logout']='backend/Auth/logout';
$route['admin/index'] = 'backend/Admin/index';

$route['admin/register'] = 'backend/User/register';
$route['admin/users'] = 'backend/User/users';
$route['admin/change-password'] = 'backend/User/changePassword';
$route['admin/profile'] = 'backend/User/index';

$route['admin/teachers'] ='backend/Teacher/index';
$route['admin/teacher/create'] = 'backend/Teacher/register';
$route['admin/teacher/status'] = 'backend/Teacher/status';
$route['admin/(:any)/teacher'] = 'backend/Teacher/edit/$1';
$route['admin/teacher/(:any)/delete']="backend/Teacher/delete/$1";

$route['admin/students'] ='backend/Student/index';
$route['admin/student/status'] = 'backend/Student/status';
$route['admin/student/(:any)/delete']="backend/Student/delete/$1";

$route['admin/payments'] ='backend/Payment/index';
$route['admin/payment/(:any)/delete']="backend/Payment/delete/$1";
$route['admin/payment/status'] = 'backend/Payment/status';
$route['admin/notify'] = 'backend/Payment/notification';

$route['admin/student'] ='backend/Student/index';
$route['admin/student/status']="backend/Student/status";

$route['admin/subscriptions'] ='backend/Subscription/index';
$route['admin/subscription/(:any)/delete']="backend/Subscription/delete/$1";

$route['admin/notices'] ='backend/Notice/index';
$route['admin/notices/store'] ='backend/Notice/store';
$route['admin/notices/(:any)/edit'] ='backend/Notice/edit/$1';
$route['admin/notices/(:any)/delete'] ='backend/Notice/delete/$1';

$route['admin/lessons'] ='backend/Lesson/index';
$route['admin/lesson/store'] = 'backend/Lesson/store';
$route['admin/(:any)/lesson'] = 'backend/Lesson/edit/$1';
$route['admin/lesson/(:any)/delete']="backend/Lesson/delete/$1";

$route['admin/levels'] ='backend/Level/index';
$route['admin/level/store'] = 'backend/Level/store';
$route['admin/(:any)/level'] = 'backend/Level/edit/$1';
$route['admin/level/(:any)/delete']="backend/Level/delete/$1";
$route['admin/level/(:any)/up']="backend/Level/moveUp/$1";
$route['admin/level/(:any)/down']="backend/Level/moveDown/$1";

$route['admin/faqs'] ='backend/Faqs/index';
$route['admin/faq/store'] = 'backend/Faqs/store';
$route['admin/(:any)/faq'] = 'backend/Faqs/edit/$1';
$route['admin/faq/(:any)/delete']="backend/Faqs/delete/$1";

$route['admin/terms'] ='backend/Term/index';
$route['admin/term/store'] = 'backend/Term/store';
$route['admin/(:any)/term'] = 'backend/Term/edit/$1';
$route['admin/term/(:any)/delete']="backend/Term/delete/$1";

$route['admin/samplevideos'] ='backend/Samplevideo/index';
$route['admin/samplevideo/store'] = 'backend/Samplevideo/store';
$route['admin/(:any)/samplevideo'] = 'backend/Samplevideo/edit/$1';
$route['admin/samplevideo/(:any)/delete']="backend/Samplevideo/delete/$1";

$route['admin/messages'] ='backend/Message/index';
$route['admin/(:any)/message'] = 'backend/Message/view/$1';
$route['admin/message/(:any)/delete']="backend/Message/delete/$1";

$route['admin/topics'] ='backend/Topic/index';
$route['admin/topic/store'] = 'backend/Topic/store';
$route['admin/topic/(:any)/delete']="backend/Topic/delete/$1";
$route['admin/(:any)/topic'] = 'backend/Topic/edit/$1';
$route['admin/(:any)/topic/lessons'] = 'backend/Lesson/topicLessons/$1';
$route['admin/(:any)/topic/lesson/store'] = 'backend/Lesson/storeTopicLesson/$1';
$route['admin/(:any)/topic/lessonEdit/(:any)'] = 'backend/Lesson/editTopicLesson/$1/$2';
$route['admin/(:any)/topic/lessonDelete/(:any)']="backend/Lesson/deleteTopicLesson/$1/$2";
$route['admin/(:any)/topic/lessonUp/(:any)']="backend/Lesson/moveUp/$1/$2";
$route['admin/(:any)/topic/lessonDown/(:any)']="backend/Lesson/moveDown/$1/$2";

$route['admin/subjects'] ='backend/Subject/index';
$route['admin/subject/store'] = 'backend/Subject/store';
$route['admin/(:any)/subject'] = 'backend/Subject/edit/$1';
$route['admin/subject/(:any)/delete']="backend/Subject/delete/$1";
/*backend routes*/
$route['default_controller'] = 'welcome';
$route['404_override'] = 'Custom404';
$route['translate_uri_dashes'] = FALSE;
