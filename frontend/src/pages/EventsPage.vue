<template>
  <q-page padding>
    <div class="row q-col-gutter-lg">
      <!-- Calendar -->
      <div class="col-12 col-md-4">
        <q-date
          v-model="selectedDate"
          :events="eventDates"
          event-color="primary"
          minimal
          class="full-width"
          @update:model-value="onDateSelected"
        />
        <q-btn
          v-if="selectedDate"
          flat
          color="primary"
          label="Clear filter"
          class="q-mt-sm full-width"
          @click="clearFilter"
        />
      </div>

      <!-- Event Cards -->
      <div class="col-12 col-md-8">
        <div v-if="loading" class="flex flex-center q-pa-xl">
          <q-spinner color="primary" size="3em" />
        </div>

        <div v-else-if="filteredEvents.length === 0" class="text-center text-grey q-pa-xl">
          <q-icon name="event_busy" size="3em" />
          <div class="q-mt-sm text-h6">No events found</div>
          <div v-if="selectedDate" class="text-body2">No events on {{ formatDate(selectedDate) }}</div>
        </div>

        <div v-else class="row q-col-gutter-md">
          <div
            v-for="event in filteredEvents"
            :key="event.id"
            class="col-12 col-sm-6"
          >
            <q-card
              class="cursor-pointer full-height"
              @click="$router.push(`/events/${event.slug}`)"
            >
              <q-card-section>
                <div class="text-h6 text-weight-bold">{{ event.title }}</div>
                <div class="text-caption text-grey q-mt-xs">
                  <q-icon name="schedule" size="xs" /> {{ formatDateTime(event.start_date) }}
                </div>
                <div class="text-caption text-grey q-mt-xs">
                  <q-icon name="location_on" size="xs" /> {{ event.venue_name || event.venue || event.place?.name }}
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import { api } from '../boot/axios.js'

// ── Temporary fake data (remove before PR) ──────────────────────────────────
const FAKE_EVENTS = [
  {
    id: 1,
    title: 'Tagum City Fiesta',
    slug: 'tagum-city-fiesta',
    start_date: '2026-11-14T18:00:00',
    venue: 'Tagum City Plaza',
  },
  {
    id: 2,
    title: 'Musikahan Festival',
    slug: 'musikahan-festival',
    start_date: '2026-11-20T09:00:00',
    venue: 'Ateneo de Davao University Gymnasium',
  },
  {
    id: 3,
    title: 'Kadayawan sa Dabaw',
    slug: 'kadayawan-sa-dabaw',
    start_date: '2026-11-14T07:00:00',
    venue: 'Magsaysay Park, Davao City',
  },
]
// ── End fake data ────────────────────────────────────────────────────────────

const events = ref([])
const loading = ref(false)
const selectedDate = ref(null)

async function fetchEvents() {
  loading.value = true
  try {
    const { data } = await api.get('/events?upcoming=1')
    events.value = data.data ?? data
  } catch {
    // API not ready yet — use fake data
    events.value = FAKE_EVENTS
  } finally {
    loading.value = false
  }
}

// Array of 'YYYY/MM/DD' strings for q-date :events prop
const eventDates = computed(() =>
  [...new Set(
    events.value.map((e) => e.start_date.slice(0, 10).replaceAll('-', '/'))
  )]
)

// Filter events to the selected date, or show all if none selected
const filteredEvents = computed(() => {
  if (!selectedDate.value) return events.value
  const selected = selectedDate.value.replaceAll('/', '-') // q-date gives YYYY/MM/DD
  return events.value.filter((e) => e.start_date.startsWith(selected))
})

function onDateSelected(val) {
  selectedDate.value = val
}

function clearFilter() {
  selectedDate.value = null
}

// Format 'YYYY-MM-DD' → 'Nov 14, 2026'
function formatDate(dateStr) {
  const normalized = dateStr.replaceAll('/', '-')
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  }).format(new Date(normalized))
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

onMounted(fetchEvents)
</script>