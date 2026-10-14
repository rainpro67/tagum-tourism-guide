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
      { path: '', component: () => import('@/pages/IndexPage.vue') },
      { path: 'places', component: () => import('@/pages/PlacesPage.vue') },
      { path: 'places/:slug', component: () => import('@/pages/PlaceDetailPage.vue') },
      { path: 'events', component: () => import('@/pages/EventsPage.vue') },
      { path: 'events/:slug', component: () => import('@/pages/EventDetailPage.vue') },
      { path: 'favorites', component: () => import('@/pages/FavoritesPage.vue') },
      { path: 'register', component: () => import('@/pages/RegisterPage.vue') },
    ],
  },

  // Keep the catch-all route last
  {
    path: '/:catchAll(.*)*',
    component: () => import('@/pages/ErrorNotFound.vue'),
  },
]

export default routes