import {
    createNotifier,
    NotificationGroup,
    defineNotificationComponent,
} from "notiwind";

export type NotificationSchema = {
    title: string;
    message: string;
    type?: "success" | "error" | "info" | "warning";
};

export const notify = createNotifier<NotificationSchema>();
export const Notification = defineNotificationComponent<NotificationSchema>();
export { NotificationGroup };
