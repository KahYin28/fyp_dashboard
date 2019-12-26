import Home from "./pages/Home.vue";
import Dashboard from "./pages/Dashboard.vue";
// import StudentList from "./pages/StudentList";
import Emotions from "./pages/Emotions";
import Lights from "./pages/Lights.vue"
import Temperature from "./pages/Temperature";
import Hello from "./pages/Hello";
// import ClassEmotions from "./pages/ClassEmotions";
import StudentAttendanceList from "./pages/StudentAttendanceList";

export const routes = [
    {
        path: '/hello',
        name: 'Hello',
        component: Hello,
    },
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
    },
    // {
    //     path: '/register',
    //     name: 'StudentList',
    //     component: StudentList
    // },
    {
        path: '/attendance',
        name: 'StudentAttendanceList',
        component: StudentAttendanceList
    },
    {
        path: '/emotion',
        name: 'Emotions',
        component: Emotions
    },
    {
        path: '/lights',
        name: 'Lights',
        component: Lights
    },
    {
        path: '/temperature/',
        name: 'Temperature',
        component: Temperature
    },
    // {
    //     path: '/classemo',
    //     name: 'ClassEmotions',
    //     component: ClassEmotions
    // },
]




