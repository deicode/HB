moment.locale("fr");

var picker2 = new Pikaday({
    field: document.getElementById('start'),
    format: 'D MMM YYYY',
    minDate: new Date(),
    onSelect: function() {
        console.log(this.getMoment().format('Do MMM YYYY'));
    }

});
var picker = new Pikaday({
    field: document.getElementById('end'),
    format: 'D MMM YYYY',
    minDate: new Date(),
    onSelect: function() {
        console.log(this.getMoment().format('Do MMM YYYY'));
    }
});