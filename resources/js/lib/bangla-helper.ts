// prettier-ignore
export const bnNumbers = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];

// prettier-ignore
export const enNumbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

// prettier-ignore
export const bengaliLiterature = [
        'ক', 'খ', 'গ', 'ঘ', 'ঙ',
        'চ', 'ছ', 'জ', 'ঝ', 'ঞ',
        'ট', 'ঠ', 'ড', 'ঢ', 'ণ',
        'ত', 'থ', 'দ', 'ধ', 'ন',
        'প', 'ফ', 'ব', 'ভ', 'ম',
        'য', 'র', 'ল', 'শ', 'ষ', 'স', 'হ',
        'ড়', 'ঢ়', 'য়',
        '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯',
    ];
// prettier-ignore
export const englishLiterature = [
        'ka', 'kha', 'ga', 'gha', 'uma',
        'cha', 'scha', 'ja', 'jha', 'neo',
        'ta', 'tha', 'da', 'dha', 'n',
        'Ta', 'Tha', 'Da', 'Dha', 'Na',
        'pa', 'pha', 'ba', 'bha', 'ma',
        'ja', 'ra', 'la', 'sha', 'sha', 'sa', 'ha',
        'ra', 'ra', 'ya',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
    ];

export function bn2en(number: string | number): string {
    return number.toString().replaceAll(/[১২৩৪৫৬৭৮৯০]/g, function (w) {
        return enNumbers[bnNumbers.indexOf(w)];
    });
}

export function en2bn(number: string | number): string {
    if (!number) return "";

    return number.toString().replaceAll(/[1234567890]/g, function (w) {
        return bnNumbers[enNumbers.indexOf(w)];
    });
}
