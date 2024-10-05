import dayjs from "dayjs";

export function pick<T>(obj: T, items: (keyof T)[]): T {
    const newObj = {} as T;
    items.forEach((item) => {
        newObj[item] = obj[item];
    });
    return newObj;
}

export function omit<T extends Object>(obj: T, items: (keyof T)[]): T {
    const newObj: any = {};
    Object.keys(obj).forEach((key) => {
        if (!items.includes(key as keyof T)) {
            newObj[key] = obj[key as keyof T];
        }
    });
    return newObj;
}

export function getPathnameFromUrl(url: string): string {
    return new URL(url).pathname;
}

export function formatDate(date?: Date | string): string {
    if (!date) {
        return "";
    }

    return dayjs(date).format("DD MMM, YYYY");
}

export function formatCurrency(amount: number): string {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "BDT",
    }).format(amount);
}

export function padZero(num?: number | string, length: number = 2): string {
    if (typeof num === "undefined") {
        return "";
    }

    return num.toString().padStart(length, "0");
}
