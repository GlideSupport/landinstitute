document.addEventListener('DOMContentLoaded', function () {
    /**
     * Function to toggle the accordion by expanding or collapsing the answer.
     * @param {HTMLElement} question - The clicked question element.
     */
    function toggleAccordion(question) {
        const answer = question.nextElementSibling; // Select the sibling answer container
        const icon = question.querySelector('.icon-shape'); // Find the icon-shape within the question
        if (answer) {
            if (question.classList.contains('active')) {
                // Expand the answer dynamically
                answer.style.maxHeight = `${answer.scrollHeight}px`;
                if (icon) icon.classList.add('active'); // Add 'active' to the icon
            } else {
                // Collapse the answer
                answer.style.maxHeight = '0px';
                if (icon) icon.classList.remove('active'); // Remove 'active' from the icon
            }
        }
    }

    /**
     * Function to reset all accordions by collapsing any open answers and removing active classes.
     */
    function resetAccordion() {
        const activeQuestions = document.querySelectorAll('.faq_question.active'); // Select all active questions
        activeQuestions.forEach((activeQuestion) => {
            const activeAnswer = activeQuestion.nextElementSibling; // Select the active answer container
            const activeIcon = activeQuestion.querySelector('.icon-shape'); // Find the icon-shape in the active question
            if (activeAnswer) {
                activeAnswer.style.maxHeight = '0px'; // Collapse the answer
            }
            if (activeIcon) {
                activeIcon.classList.remove('active'); // Remove 'active' from the icon
            }
            activeQuestion.classList.remove('active'); // Remove the active class from the question
        });
    }

    // Select all FAQ question elements
    const questions = document.querySelectorAll('.faq_question');
    if (questions.length > 0) {
        questions[0].classList.add('active');
        toggleAccordion(questions[0]);
    }

    // Add a click event listener to each question
    questions.forEach((question) => {
        question.addEventListener('click', () => {
            if (question.classList.contains('active')) {
                // If the clicked question is already active, collapse it
                question.classList.remove('active');
                toggleAccordion(question);
            } else {
                // Reset other accordions and expand the clicked one
                resetAccordion();
                question.classList.add('active');
                toggleAccordion(question);
            }
        });
    });

    /**
     * Function to adjust the height of the active accordion on window resize.
     */
    window.addEventListener('resize', () => {
        const activeQuestion = document.querySelector('.faq_question.active');
        if (activeQuestion) {
            toggleAccordion(activeQuestion);
        }
    });
});
