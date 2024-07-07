document.addEventListener('DOMContentLoaded', function() {
    const addPropositionButton = document.getElementById('add-proposition');
    const propositionsList = document.getElementById('propositions-list');

    let index = propositionsList.getElementsByTagName('input').length;

    addPropositionButton.addEventListener('click', function() {
        const prototype = propositionsList.dataset.prototype;
        const newForm = prototype.replace(/__name__/g, index);

        const newFormElement = document.createElement('div');
        newFormElement.innerHTML = newForm;
        propositionsList.appendChild(newFormElement);

        index++;
    });
});
