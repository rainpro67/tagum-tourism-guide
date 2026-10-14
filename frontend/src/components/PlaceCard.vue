<template>
  <q-card
    class="place-card column justify-between"
    flat
    bordered
    :to="`/places/${placeSlug}`"
    @click="navigate"
  >
    <q-img
      :src="imageSrc"
      :alt="place?.name || 'Place image'"
      class="place-image"
      :ratio="16 / 9"
    >
      <div
        v-if="categoryName"
        class="absolute-top-left q-pa-xs place-category-chip"
      >
        <q-badge color="primary" class="q-px-sm q-py-xs place-category">
          {{ categoryName }}
        </q-badge>
      </div>
      <template #error>
        <div class="absolute-full flex flex-center bg-grey-3 text-grey-7">
          <q-icon name="image_not_supported" size="32px" />
        </div>
      </template>
    </q-img>

    <q-card-section class="q-pb-none">
      <div
        v-if="categoryName"
        class="text-overline text-primary place-category"
      >
        {{ categoryName }}
      </div>
      <div class="text-h6 text-weight-bold q-mt-xs q-mb-xs place-name">
        <router-link
          :to="`/places/${placeSlug}`"
          class="place-link text-dark text-decoration-none"
        >
          {{ place?.name }}
        </router-link>
      </div>
    </q-card-section>

    <q-card-section class="q-pt-none col">
      <p class="text-body2 text-grey-8 place-description">
        {{ shortDescription }}
      </p>
    </q-card-section>

    <q-card-actions align="right" class="q-pt-none q-pb-md q-px-md">
      <q-btn
        flat
        color="primary"
        label="View Details"
        icon-right="arrow_forward"
        :to="`/places/${placeSlug}`"
        class="place-btn"
        no-caps
      />
    </q-card-actions>
  </q-card>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const props = defineProps({
  place: {
    type: Object,
    required: true,
    default: () => ({})
  }
})

const router = useRouter()

const placeSlug = computed(() => {
  return props.place?.slug || props.place?.id || ''
})

const categoryName = computed(() => {
  if (!props.place) return ''
  if (typeof props.place.category === 'string') return props.place.category
  if (props.place.category && typeof props.place.category === 'object') {
    return props.place.category.name || ''
  }
  return props.place.category_name || ''
})

const imageSrc = computed(() => {
  return (
    props.place?.image ||
    props.place?.image_path ||
    'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80'
  )
})

const shortDescription = computed(() => {
  return props.place?.short_description || props.place?.description || ''
})

function navigate() {
  if (router && placeSlug.value) {
    router.push(`/places/${placeSlug.value}`).catch(() => {})
  }
}
</script>

<style scoped>
.place-card {
  height: 100%;
  border-radius: 12px;
  overflow: hidden;
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
  cursor: pointer;
}
.place-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}
.place-link {
  text-decoration: none;
  color: inherit;
}
.place-link:hover {
  color: var(--q-primary);
}
.place-description {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
