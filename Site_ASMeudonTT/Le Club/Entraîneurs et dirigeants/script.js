// Add animation on hover for coaches and managers
const coaches = document.querySelectorAll('.coach');
const managers = document.querySelectorAll('.manager');

coaches.forEach(coach => {
	coach.addEventListener('mouseenter', () => {
		coach.classList.add('animate__animated', 'animate__bounce');
	});
	coach.addEventListener('mouseleave', () => {
		coach.classList.remove('animate__animated', 'animate__bounce');
	});
});

managers.forEach(manager => {
	manager.addEventListener('mouseenter', () => {
		manager.classList.add('animate__animated', 'animate__pulse');
	});
	manager.addEventListener('mouseleave', () => {
		manager.classList.remove('animate__animated', 'animate__pulse');
	});
});
