
if (typeof(HypCsDate) == "undefined") {
	HypCsDate = function (months, days) {
		this.months = months;
		this.days = days;
	};
}

HypCsDate.prototype = {
	monthDays : {
					0 : {1:[1,31], 2:[1,28], 3:[1,31], 4:[1,30], 5:[1,31], 6:[1,30], 7:[1,31], 8:[1,31], 9:[1,30], 10:[1,31], 11:[1,30], 12:[1,31]},
					1 : {1:[1,31], 2:[1,29], 3:[1,31], 4:[1,30], 5:[1,31], 6:[1,30], 7:[1,31], 8:[1,31], 9:[1,30], 10:[1,31], 11:[1,30], 12:[1,31]}
				},
	months : {},
	days : {},
	year_prefix : "",
	month_prefix : "",
	day_prefix : "",

	isLeapYear: function (year) {
		if (year%100 == 0) {
			year /= 100;
		}
		return (year%4) ? 0 : 1;
	},

	populate : function (rootName, minDate, maxDate, selected) {
		if (typeof(selected) != 'object') {
			var today = new Date();
			selected = [today.getFullYear(), today.getMonth() + 1, today.getDate()];
		}
		var rootList = rootName + '-list';
		addListGroup(rootName, rootList);

		var _year_ind = {0:false, 1:false};
		var isLeap;
		var yearList;
		var year;
		if (this.year_prefix) {
			isLeap = 1;
			yearList = rootList + '-' + isLeap;
			addList(rootList, this.year_prefix, '0', yearList);
			if (!_year_ind[isLeap]) {
				this._populateMonths(yearList, this.monthDays[isLeap]);
				_year_ind[isLeap] = true;
			}
		}

		var minYear = minDate[0];
		var maxYear = maxDate[0];
		var _monthDays = {};
		if (minYear == maxYear) {
			year = minYear;
			isLeap = this.isLeapYear(year);
			yearList = rootList + '-year';
			addList(rootList, year, year, yearList);
			for (var i = minDate[1]; i <= maxDate[1]; i++) {
				_monthDays[i] = this.monthDays[isLeap][i];
			}
			_monthDays[minDate[1]][0] = minDate[2];
			_monthDays[maxDate[1]][1] = maxDate[2];
			this._populateMonths(yearList, _monthDays);
		} else if (minYear < maxYear) {
			/* for optimization */
			var minWhole = (minDate[1] == 1) && (minDate[2] == 1); // if it is January 1 (first day of the year)

			if (!minWhole) {
				year = minYear;
				isLeap = this.isLeapYear(year);
				yearList = rootList + '-min';
				addList(rootList, minYear, minYear, yearList);
				_monthDays = {};
				for (var i = minDate[1]; i <= 12; i++) {
					/* Avoid passing by reference */
					_monthDays[i] = [];
					_monthDays[i][0] = this.monthDays[isLeap][i][0];
					_monthDays[i][1] = this.monthDays[isLeap][i][1];
				}
				_monthDays[minDate[1]][0] = minDate[2];
				this._populateMonths(yearList, _monthDays);
			}

			/* for optimization */
			var maxWhole = (maxDate[1] == 12) && (maxDate[2] == 31); // if it is December 31 (last day of the year)

			for (year = minYear + (minWhole ? 0 : 1); year < maxYear + (maxWhole ? 1 : 0); year++) {
				isLeap = this.isLeapYear(year);
				yearList = rootList + '-' + isLeap;
				addList(rootList, year, year, yearList);
				if (!_year_ind[isLeap]) {
					this._populateMonths(yearList, this.monthDays[isLeap]);
					_year_ind[isLeap] = true;
				}
			}

			if (!maxWhole) {
				year = maxYear;
				isLeap = this.isLeapYear(year);
				yearList = rootList + '-max';
				addList(rootList, year, year, yearList);
				_monthDays = {};
				for (var i = 1; i <= maxDate[1]; i++) {
					/* Avoid passing by reference */
					_monthDays[i] = [];
					_monthDays[i][0] = this.monthDays[isLeap][i][0];
					_monthDays[i][1] = this.monthDays[isLeap][i][1];
				}
				_monthDays[maxDate[1]][1] = maxDate[2];
				this._populateMonths(yearList, _monthDays);
			}

		}

		selectOptions(rootName, selected[0] + '::' + selected[1] + '::' + selected[2], 1);
	},

	_populateMonths : function (yearList, monthDays) {
		var _month_ind = {};
		var days;
		var monthList;
		if (this.month_prefix) {
			days = [1,31];
			monthList = yearList + '-' + days.toString();
			addList(yearList, this.month_prefix, '0', monthList);
			if (typeof(_month_ind[days.toString()]) == "undefined") {
				this._populateDays(monthList, days[0], days[1]);
				_month_ind[days.toString()] = true;
			}
		}
		for (var month in monthDays) {
			if (parseInt(month) > 0) {
				days = monthDays[month];
				monthList = yearList + '-' + days.toString();
				addList(yearList, this.months[month], month, monthList);
				if (typeof(_month_ind[days.toString()]) == "undefined") {
					this._populateDays(monthList, days[0], days[1]);
					_month_ind[days.toString()] = true;
				}
			}
		}
	},

	_populateDays : function (monthList, minDay, maxDay) {
		if (this.day_prefix)
			addOption(monthList, this.day_prefix, '0');

		for (var day = minDay; day <= maxDay; day++) {
			addOption(monthList, this.days[day], day);
		}
	}
}
