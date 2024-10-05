import relativeTime from "dayjs/plugin/relativeTime";
import dayjs from "dayjs";

dayjs.extend(relativeTime);

export function dateFromNow(date: string | Date) {
    return dayjs(date).fromNow();
}
