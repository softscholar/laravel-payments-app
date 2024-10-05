import { Setting, SettingsKey } from "@/types";
import { usePage } from "@inertiajs/vue3";

// Define overloads
export function useSettings(): Setting;
export function useSettings<K extends SettingsKey>(
    name: K,
    defaultValue?: Setting[K]
): Setting[K];

// Main implementation
export function useSettings(
    name?: SettingsKey,
    defaultValue?: Setting[SettingsKey]
) {
    const { props } = usePage();

    if (name) {
        return props.settings[name] ?? defaultValue;
    }

    return props.settings;
}
