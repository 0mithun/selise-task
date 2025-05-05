import Index from '@/pages/Employes/Index.vue'
import Edit from '@/pages/Employes/Edit.vue'
import Create from '@/pages/Employes/Create.vue'

const routes = [
    {
        path: '/employees',
        name: 'employees.index',
        component: Index,
        meta: { title: 'Employee', }
    },
    {
        path: '/employees/create',
        name: 'employees.create',
        component: Create,
        meta: { title: 'Employee Create', }
    },
    {
        path: '/employees/:id/edit',
        name: 'employees.edit',
        component: Edit,
        meta: { title: 'Employee Edit', }
    },
]

export default routes;
