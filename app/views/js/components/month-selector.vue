<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { OptionType } from '../types/option-type';
import api from '../utils/axios';
import { useI18n } from 'vue-i18n'

const { t, locale } = useI18n();
const selected = ref('');
const options = ref<OptionType[]>([] as OptionType[]);
const hasReportedRecord = ref(false);
const emit = defineEmits([
    'change-month'
]);

async function currentMonthHasReportedRecord() {
  const { data } = await api.get<{hasAny : boolean}>('has-reported-record');
  hasReportedRecord.value = data.hasAny;
}

const generateMonthOptions = () : OptionType[] => {
  const options: OptionType[] = [
    {
        value: '0',
        label: t('month-selector.choose-other')
    }
  ];
  const today = new Date();
  let year = today.getFullYear();
  let month = hasReportedRecord.value ? today.getMonth() + 1 : today.getMonth();

  while (year > 2024 || (year === 2025 && month >= 1)) {
    const monthStr = month.toString().padStart(2, '0');
    options.push({
      value: `${year}-${monthStr}`,
      label: `${year}-${monthStr}`
    });

    month--;
    if (month === 0) {
      month = 12;
      year--;
    }
  }

  return options;
}

onMounted(() => {
  options.value = generateMonthOptions();
  selected.value = options.value[0].value;
});

watch(locale, () => {
  options.value = generateMonthOptions()
});

const handleChange = () => {
    emit('change-month', selected.value);
}

currentMonthHasReportedRecord();
</script>

<template>
  <div class="my-3">
    <select
      id="monthYear"
      v-model="selected"
      @change="handleChange"
      class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-full
             bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100
             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
             transition-colors duration-200"
    >
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>