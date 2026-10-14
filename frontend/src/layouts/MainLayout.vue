   <template>
     <q-layout view="hHh lpR fFf">
       <q-header elevated>
         <q-toolbar>
           <q-toolbar-title>Tagum Tourism Guide</q-toolbar-title>
           <q-btn flat label="Home" to="/" />
           <q-btn flat label="Places" to="/places" />
           <q-btn flat label="Events" to="/events" />
           <q-btn flat label="Favorites" to="/favorites" />
           <q-btn flat label="Login" to="/login" />
         </q-toolbar>
       </q-header>

       <q-page-container>
         <router-view />
       </q-page-container>
     </q-layout>
   </template>