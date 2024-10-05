import { computed, ComputedRef } from "vue";

export const useGetQueryParams = <T = Record<string, string>>(): T => {
    const searchParams = new URLSearchParams(window.location.search);
    return computed<T>(() => {
        const params: Record<string, string> = {};

        searchParams.forEach((value, key) => {
            params[key] = value;
        });

        return params as T;
    }).value;
};
