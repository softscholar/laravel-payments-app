import { usePage } from "@inertiajs/vue3";

export const useSubDomain = (): string => {
    const { props } = usePage();

    if (props.subdomain) {
        return props.subdomain;
    }

    const host = window.location.host;

    if (host.includes("localhost")) {
        return "";
    }

    const parts = host.split(".");

    if (parts.length > 2) {
        return parts[0];
    }

    return "";
};
