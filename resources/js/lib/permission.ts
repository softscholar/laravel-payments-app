/**
 * This file contains all the permissions that are used in the application.
 *
 * Sync the permissions with the backend.
 * \App\Enums\Permission
 */
export enum Permission {
    MANAGE_INFO = "manage info",
    MANAGE_BANK = "manage bank",
    MANAGE_APPROVER = "manage approver",
    MANAGE_PIPE_SIZE = "manage pipe size",
    MANAGE_TARIFF = "manage tariff",

    READ_CUSTOMER = "read customer",
    WRITE_CUSTOMER = "write customer",
    MANAGE_HOLDING = "manage holding",

    MANAGE_BILLING = "manage billing",
    MANAGE_METER_READING = "manage meter reading",
    MANAGE_METERS = "manage meters",

    MANAGE_PAYMENT = "manage payment",
    MANAGE_TRANSACTION = "manage transaction",

    DASHBOARD_VIEW = "dashboard view",
    DASHBOARD_CONTENT = "dashboard content",

    USER_READ = "user read",
    USER_WRITE = "user write",

    ROLE_READ = "role read",
    ROLE_WRITE = "role write",

    USER_ASSIGN_READ = "user assign read",
    USER_ASSIGN_WRITE = "user assign write",

    UPDATE_SETTING = "update setting",
    UPDATE_BILLING_SETTING = "update billing setting",

    ALL = "ALL",
}
