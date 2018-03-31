import expect from 'expect';
import moment from "moment/moment";
import Month from "../../../../resources/assets/js/models/Month.js"

describe('Month', () => {
    it('formats month as string', () => {
        let today = new Month(2018, 3);
        expect(today.toString()).toEqual('2018-03');
    });

    it('returns current month', () => {
        let today = Month.current();
        expect(today.toString()).toEqual(moment().format('YYYY-MM'));
    });

    it('returns previous month', () => {
        let month = new Month(2018, 3).previous();
        expect(month.toString()).toEqual('2018-02');
    });

    it('returns next month', () => {
        let month = new Month(2018, 3).next();
        expect(month.toString()).toEqual('2018-04');
    });
});
