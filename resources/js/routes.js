import Home from "./pages/Home.vue";
import Dashboard from "./pages/Dashboard.vue";
import Emotions from "./pages/Emotions";
import Lights from "./pages/Lights.vue"
import Temperature from "./pages/Temperature";
import StudentAttendanceList from "./pages/StudentAttendanceList";

export const routes = [

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

]




