<template>
  <q-page padding>
    <!-- Loading -->
    <div v-if="loading" class="flex flex-center q-pa-xl">
      <q-spinner color="primary" size="3em" />
    </div>

    <!-- 404 Not Found -->
    <div v-else-if="notFound" class="flex flex-center q-pa-xl">
      <div class="text-center">
        <q-icon name="event_busy" size="4em" color="grey" />
        <div class="text-h5 q-mt-md">Event Not Found</div>
        <div class="text-body1 text-grey q-mt-sm">
          The event you're looking for doesn't exist or may have been removed.
        </div>
        <q-btn
          class="q-mt-lg"
          color="primary"
          label="Back to Events"
          to="/events"
          unelevated
        />
      </div>
    </div>

    <!-- Event Detail -->
    <div v-else-if="event" class="row justify-center">
      <div class="col-12 col-md-8">
        <q-btn
          flat
          color="primary"
          icon="arrow_back"
          label="All Events"
          to="/events"
          class="q-mb-md"
        />

        <q-card flat bordered>
          <q-card-section>
            <div class="text-h4 text-weight-bold">{{ event.title }}</div>

            <div class="q-mt-md q-gutter-sm">
              <div class="text-body1">
                <q-icon name="schedule" color="primary" /> {{ formatDateTime(event.start_date) }}
              </div>
              <div v-if="event.end_date" class="text-body1">
                <q-icon name="event" color="primary" /> ends {{ formatDateTime(event.end_date) }}
              </div>
              <div v-if="event.venue_name || event.venue || event.place?.name" class="text-body1">
                <q-icon name="location_on" color="primary" /> {{ event.venue_name || event.venue || event.place?.name }}
              </div>
            </div>
          </q-card-section>

          <q-separator />

          <q-card-section v-if="event.description">
            <div class="text-h6 q-mb-sm">About this Event</div>
            <div class="text-body1" style="white-space: pre-wrap">{{ event.description }}</div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { api } from '../boot/axios.js'

const route = useRoute()

const event = ref(null)
const loading = ref(false)
const notFound = ref(false)

// ── Temporary fake data (remove before PR) ──────────────────────────────────
const FAKE_EVENTS = {
  'tagum-city-fiesta': {
    id: 1,
    title: 'Tagum City Fiesta',
    slug: 'tagum-city-fiesta',
    start_date: '2026-11-14T18:00:00',
    end_date: '2026-11-14T23:00:00',
    venue: 'Tagum City Plaza',
    description: 'Annual celebration of Tagum City\'s founding anniversary featuring cultural performances, food stalls, and fireworks.',
  },
  'musikahan-festival': {
    id: 2,
    title: 'Musikahan Festival',
    slug: 'musikahan-festival',
    start_date: '2026-11-20T09:00:00',
    end_date: '2026-11-20T17:00:00',
    venue: 'Ateneo de Davao University Gymnasium',
    description: 'A music festival celebrating the vibrant musical heritage of the Davao Region.',
  },
  'kadayawan-sa-dabaw': {
    id: 3,
    title: 'Kadayawan sa Dabaw',
    slug: 'kadayawan-sa-dabaw',
    start_date: '2026-11-14T07:00:00',
    end_date: '2026-11-14T18:00:00',
    venue: 'Magsaysay Park, Davao City',
    description: 'A thanksgiving festival featuring street dancing, floral floats, and indigenous cultural performances.',
  },
}
// ── End fake data ────────────────────────────────────────────────────────────

async function fetchEvent() {
  loading.value = true
  const slug = route.params.slug
  try {
    const { data } = await api.get(`/events/${slug}`)
    event.value = data.data ?? data
  } catch (err) {
    if (err.response?.status === 404) {
      notFound.value = true
    } else {
      // API not ready yet — use fake data
      const fake = FAKE_EVENTS[slug]
      if (fake) {
        event.value = fake
      } else {
        notFound.value = true
      }
    }
  } finally {
    loading.value = false
  }
}

// Format ISO datetime → 'Nov 14, 2026, 6:00 PM'
function formatDateTime(dateStr) {
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: 'numeric',
    minute: '2-digit',
    hour12: true,
  }).format(new Date(dateStr))
}

onMounted(fetchEvent)
</script>