export interface StatResponse {
    month: string,
    year: string,
    consumption: number,
    lastReportedAmount: number,
    maxLimit: number,
    lastReading: number,
    remaining: number,
    overConsumption: number,
    clockSetting: number
}