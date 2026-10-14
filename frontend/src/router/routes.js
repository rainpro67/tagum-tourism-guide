const routes = [
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
      { path: 'login', component: () => import('@/pages/LoginPage.vue') },
      { path: 'register', component: () => import('@/pages/RegisterPage.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('@/pages/ErrorNotFound.vue')
  }
]

export default routes