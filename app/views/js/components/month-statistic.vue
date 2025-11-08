<script setup lang="ts">
import { ref, watch } from 'vue';
import Card from './card.vue';
import api from '../utils/axios';
import { StatResponse } from '../types/stat-response';
import StatisticSmiley from './statistic-smiley.vue';
import MonthSelector from './month-selector.vue';
import { useI18n } from 'vue-i18n';
import { useNetworkStatus } from '../composables/use-network-status';

const { t, locale } = useI18n();
const { isOnline } = useNetworkStatus();
const isLoading = ref(true);
const stats = ref<StatResponse>({
  month: '',
  year: '',
  monthNumber: 0,
  consumption: 0,
  lastReportedAmount: 0,
  maxLimit: 0,
  lastReading: 0,
  overConsumption: 0,
  remaining: 0,
  clockSetting: 0
});

const errorMessage = ref('');
const isCurrentMonth = ref(true);

async function fetchActualMonthStatistics() {
  if (isOnline) {
    if (localStorage.getItem('currentMonth')) {
      stats.value = JSON.parse(localStorage.getItem('currentMonth') ?? '');
      isLoading.value = false;
    } else {
      const { data } = await api.get<StatResponse>('stat');
      stats.value = data;
      isLoading.value = false;
      localStorage.setItem('currentMonth', JSON.stringify(data));
    }
  } else {
    stats.value = JSON.parse(localStorage.getItem('currentMonth') ?? '');
  }
}

async function fetchMonthStatistics(date : string) {
  try {
    const { data } = await api.get<StatResponse>('stat', {
      params: {
        date
      }
    });
    stats.value = data;
    errorMessage.value = '';
    isCurrentMonth.value = `${stats.value.year}-${stats.value.monthNumber}` === date;
  } catch (error: any) {
    errorMessage.value = error.response.data.message || t('general.unknown-error');
  } finally {
    isLoading.value = false;
  }
}

fetchActualMonthStatistics();

defineExpose({
  fetchActualMonthStatistics
});

watch(locale, () => {
  fetchActualMonthStatistics();
});
</script>
<template>
  <Card :title="`${stats.year} ${stats.month}`" class="text-center">
    <template #content>
      <template v-if="!isLoading">
        <MonthSelector @change-month="fetchMonthStatistics" v-if="isOnline"/>
        <p v-if="errorMessage.length > 0" class="text-red-500">
          {{ errorMessage }}
        </p>
        <template v-if="errorMessage.length === 0">
          <StatisticSmiley :consumption="stats.consumption" :max-limit="stats.maxLimit"/>
          <p class="pt-3"><b>{{ t('month-statistic.discounted-amount') }}:</b> {{ stats.maxLimit }} m<sup>3</sup></p>
          <p><b>{{ t('month-statistic.consumption') }}:</b> {{ stats.consumption }} m<sup>3</sup></p>
          <p><b>{{ t('month-statistic.remaining-discounted-amount') }}:</b> {{  stats.remaining }} m<sup>3</sup></p>
          <p><b>{{ t('month-statistic.overconsumption') }}:</b> {{ stats.overConsumption }} m<sup>3</sup></p>
          <template v-if="isCurrentMonth">
            <p><b>{{ t('month-statistic.last-reported') }}:</b> {{ stats.lastReportedAmount }} m<sup>3</sup></p>
            <p><b>{{ t('month-statistic.last-readed') }}:</b> {{ stats.lastReading }} m<sup>3</sup></p>
            <p><b>{{ t('month-statistic.clock-setting') }}:</b> {{ stats.clockSetting }}</p>
          </template>
        </template>
      </template>

      <template v-else>
        {{  t('general.loading') }}
      </template>
    </template>
  </Card>
</template>
