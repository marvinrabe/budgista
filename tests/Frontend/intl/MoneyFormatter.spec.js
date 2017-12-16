import expect from 'expect';
import MoneyFormatter from '../../../resources/assets/js/intl/MoneyFormatter.js';

describe('MoneyFormatter', () => {

    // Every possible format:
    // 1.234,56 international
    // 1,234.56 e.g. de
    // 1'234.56 e.g. de-CH
    // 1 234,56 e.g. fr-FR
    // 1,234/56 e.g. fa-IR
    // 1 234-56 e.g. kk-KZ
    // 1 234.56 e.g. et-EE

    // There are no non decimal currencies anymore except in two countries in Africa
    // Even there they are not used anymore.

    let formatter;

    beforeEach(() => {
        formatter = new MoneyFormatter('de', 'EUR');
    });

    it('returns a formatted currency value', () => {
        expect(formatter.format(1234.56)).toBe('1.234,56\xa0€');
    });

    it('returns an unformatted currency value', () => {
        expect(formatter.unformat('1.234,56\xa0€')).toBe(1234.56);
    });

});
