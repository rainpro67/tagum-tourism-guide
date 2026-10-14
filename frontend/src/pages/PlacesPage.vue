<template>
  <q-page class="places-page q-pa-md q-pa-md-lg">
    <div class="places-container">
      <!-- Header / Title -->
      <div class="page-header q-mb-lg">
        <h1 class="text-h4 text-weight-bold q-my-none text-primary">
          Explore Tagum City
        </h1>
        <p class="text-subtitle1 text-grey-7 q-mt-xs q-mb-none">
          Discover top tourist spots, local festivals, parks, and dining places.
        </p>
      </div>

      <!-- Search & Filters Section -->
      <div class="filters-section q-mb-lg">
        <div class="row q-col-gutter-md items-center">
          <!-- Search Box -->
          <div class="col-12 col-md-6">
            <q-input
              v-model="searchQuery"
              outlined
              dense
              rounded
              placeholder="Search places by name or description..."
              clearable
              class="search-input bg-white"
              @update:model-value="onSearchInput"
              @keyup.enter="fetchPlaces"
            >
              <template #prepend>
                <q-icon name="search" />
              </template>
              <template #append>
                <q-btn
                  v-if="searchQuery"
                  round
                  dense
                  flat
                  icon="arrow_forward"
                  color="primary"
                  @click="fetchPlaces"
                />
              </template>
            </q-input>
          </div>

          <!-- Category Buttons -->
          <div class="col-12 col-md-12">
            <div class="category-buttons row q-gutter-sm items-center">
              <q-btn
                :unelevated="selectedCategory === ''"
                :outline="selectedCategory !== ''"
                color="primary"
                rounded
                label="All"
                no-caps
                class="category-btn"
                @click="selectCategory('')"
              />

              <q-btn
                v-for="cat in categories"
                :key="cat.id || cat.slug"
                :unelevated="selectedCategory === (cat.slug || cat.name)"
                :outline="selectedCategory !== (cat.slug || cat.name)"
                color="primary"
                rounded
                :label="cat.name"
                no-caps
                class="category-btn"
                @click="selectCategory(cat.slug || cat.name)"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="loading-state flex flex-center q-py-xl">
        <div class="column items-center q-gutter-md">
          <q-spinner color="primary" size="3.5em" />
          <div class="text-grey-7 text-body1">Loading places...</div>
        </div>
      </div>

      <!-- Empty / No Results State -->
      <div
        v-else-if="places.length === 0"
        class="no-results flex flex-center q-py-xl text-center"
      >
        <div class="column items-center q-gutter-sm">
          <q-icon name="search_off" size="64px" color="grey-5" />
          <div class="text-h6 text-weight-medium text-grey-8">
            No places found
          </div>
          <p class="text-grey-6 q-mb-md" style="max-width: 400px">
            We couldn't find any places matching your criteria. Try adjusting
            your search keywords or selecting a different category.
          </p>
          <q-btn
            outline
            color="primary"
            label="Reset Filters"
            no-caps
            rounded
            @click="resetFilters"
          />
        </div>
      </div>

      <!-- Places Grid -->
      <div v-else class="places-grid row q-col-gutter-lg">
        <div
          v-for="place in places"
          :key="place.id || place.slug"
          class="col-12 col-sm-6 col-md-4 col-lg-3 flex"
        >
          <PlaceCard :place="place" class="full-width" />
        </div>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from '../boot/axios.js'
import PlaceCard from '../components/PlaceCard.vue'

const places = ref([])
const categories = ref([])
const searchQuery = ref('')
const selectedCategory = ref('')
const loading = ref(false)

let searchTimeout = null

async function fetchCategories() {
  try {
    const response = await api.get('/categories')
    const data = response.data
    categories.value = Array.isArray(data) ? data : data.data || []
  } catch (err) {
    console.error('Failed to load categories:', err)
  }
}

async function fetchPlaces() {
  loading.value = true
  try {
    const params = {}
    if (searchQuery.value && searchQuery.value.trim() !== '') {
      params.search = searchQuery.value.trim()
    }
    if (selectedCategory.value && selectedCategory.value !== 'all') {
      params.category = selectedCategory.value
    }

    const response = await api.get('/places', { params })
    const data = response.data
    places.value = Array.isArray(data) ? data : data.data || []
  } catch (err) {
    console.error('Failed to load places:', err)
    places.value = []
  } finally {
    loading.value = false
  }
}

function selectCategory(categorySlug) {
  selectedCategory.value = categorySlug
  fetchPlaces()
}

function onSearchInput() {
  if (searchTimeout) clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchPlaces()
  }, 350)
}

function resetFilters() {
  searchQuery.value = ''
  selectedCategory.value = ''
  fetchPlaces()
}

onMounted(async () => {
  await fetchCategories()
  await fetchPlaces()
})
</script>

<style scoped>
.places-page {
  background: #f8faf8;
  min-height: 100vh;
}

.places-container {
  max-width: 1280px;
  margin: 0 auto;
}

.page-header h1 {
  letter-spacing: -0.5px;
}

.search-input {
  max-width: 500px;
}

.search-input :deep(.q-field__control) {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.category-buttons {
  overflow-x: auto;
  padding-bottom: 4px;
}

.category-btn {
  font-weight: 600;
  padding: 4px 16px;
  transition: all 0.2s ease;
}

.loading-state,
.no-results {
  min-height: 350px;
}
</style>
