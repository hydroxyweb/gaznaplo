<script setup lang="ts">
import { ref } from 'vue';
import { OptionType } from '../types/option-type';
import axios from 'axios';

const selected = ref('');
const hasReportedRecord = ref(false);
const emit = defineEmits([
    'change-month'
]);

async function currentMonthHasReportedRecord() {
  const { data } = await axios.get<{hasAny : boolean}>('has-reported-record')
  hasReportedRecord.value = data.hasAny;
}

const generateMonthOptions = () : OptionType[] => {
  const options: OptionType[] = [
    {
        value: '0',
        label: 'Másik hónap statisztikája'
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

const options = generateMonthOptions();
selected.value = options[0].value;

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
      class="border rounded-lg p-2 w-full text-gray-900"
      @change="handleChange"
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
