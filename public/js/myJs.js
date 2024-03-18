function convertDateToPersian(yourDate){
    var dateFormat = new Intl.DateTimeFormat("fa",{year:"numeric",month:"2-digit",day:"2-digit"});
    yourDate=Date.parse(yourDate);
    return dateFormat.format(yourDate)
}
function convertDateToPersianDetails(yourDate){
    var dateFormat = new Intl.DateTimeFormat("fa",{year:"numeric",month:"2-digit",day:"2-digit", hour:"2-digit", minute:"2-digit", second:"2-digit"});
    yourDate=Date.parse(yourDate);
    return dateFormat.format(yourDate)
}