import { PageProps } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { Permission } from "./permission";

export const useAuth = () => {
    const {
        props: { auth },
    } = usePage<PageProps>();

    const hasRole = (role: string) =>
        auth.user.roles?.map((item) => item.name).includes(role);

    const hasPermission = (...permission: string[]) =>
        permission.includes("ALL") ||
        auth.permissions.some((item) => permission.includes(item));

    return {
        user: auth.user,
        roles: auth.user.roles,
        permissions: auth.permissions,

        hasRole,
        hasPermission,
        Permission,
    };
};
