import api from '../utils/axios';

interface LogEntryParams {
    amount: number;
    reported: boolean;
    date: string;
}

export function sendLogEntry(params : LogEntryParams) {
    return api.post('log', {params});
}