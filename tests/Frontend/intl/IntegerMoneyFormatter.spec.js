import expect from 'expect';
import IntegerMoneyFormatter from '../../../resources/assets/js/i18n/IntegerMoneyFormatter.js';

describe('IntegerMoneyFormatter', () => {

    let formatter;

    beforeEach(() => {
        formatter = new IntegerMoneyFormatter('de', 'EUR');
    });

    it('returns a formatted currency value', () => {
        expect(formatter.format(123456)).toBe('1.234,56\xa0€');
    });

    it('returns an unformatted currency value', () => {
        expect(formatter.unformat('1.234,56\xa0€')).toBe(123456);
    });

});
