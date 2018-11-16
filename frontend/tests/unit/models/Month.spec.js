import {expect} from 'chai'
import moment from "moment/moment";
import Month from "@/models/Month"

describe('Month', () => {
    it('formats month as string', () => {
        let today = new Month(2018, 3);
        expect(today.toString()).to.equal('2018-03');
    });

    it('returns current month', () => {
        let today = Month.current();
        expect(today.toString()).to.equal(moment().format('YYYY-MM'));
    });

    it('returns previous month', () => {
        let month = new Month(2018, 3).previous();
        expect(month.toString()).to.equal('2018-02');
    });

    it('returns next month', () => {
        let month = new Month(2018, 3).next();
        expect(month.toString()).to.equal('2018-04');
    });
});
