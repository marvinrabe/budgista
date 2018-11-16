import {expect} from 'chai'
import IntegerMoneyFormatter from '@/i18n/IntegerMoneyFormatter';

describe('IntegerMoneyFormatter', () => {

    let formatter;

    beforeEach(() => {
        formatter = new IntegerMoneyFormatter('de', 'EUR');
    });

    it('returns a formatted currency value', () => {
        expect(formatter.format(123456)).to.equal('1.234,56\xa0€');
    });

    it('returns an unformatted currency value', () => {
        expect(formatter.unformat('1.234,56\xa0€')).to.equal(123456);
    });

});
