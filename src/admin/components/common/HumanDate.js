const HumanDate = ( timestamp ) => {
	const date = new Date( timestamp * 1000 );
	const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	return `${date.getDate()} ${months[date.getMonth()]}, ${date.getFullYear()}`;
}

export default HumanDate;