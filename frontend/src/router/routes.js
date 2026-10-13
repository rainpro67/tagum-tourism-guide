
const routes = [
  // Authentication pages without the main navigation
  {
    path: '/login',
    component: () => import('@/layouts/AuthLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('@/pages/LoginPage.vue'),
      },
    ],
  },

  // Main application pages
  {
    path: '/',
    component: () => import('@/layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('@/pages/IndexPage.vue'),
      },
      {
        path: 'second',
        component: () => import('@/pages/SecondPage.vue'),
      },
    ],
  },

  // Keep the catch-all route last
  {
    path: '/:catchAll(.*)*',
    component: () => import('@/pages/ErrorNotFound.vue'),
  },
]

export default routes
