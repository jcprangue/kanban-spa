import boardTask from './components/task/board.vue';
import login from './components/auth/login.vue';
import createTask from './components/task/create-task.vue';
import updateTask from './components/task/update-task.vue';
 
export const routes = [
    {
        name: 'Login',
        path: '/login',
        component: login
    },
    {
        name: 'Board',
        path: '/board',
        component: boardTask
    },
    {
        name: 'Create',
        path: '/task/create/:status',
        component: createTask,
        props: true
    },
    {
        name: 'Update',
        path: '/task/:id/update',
        component: updateTask,
        props: true
    }

];