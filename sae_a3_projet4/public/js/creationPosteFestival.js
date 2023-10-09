const addTagFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerText = '❌';

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        if(postes.dataset.index > 1){
            e.preventDefault();
            postes.dataset.index--;
            item.remove();
        }
    });
}

const addFormToCollection = () => {
    const item = document.createElement('fieldset');

    item.innerHTML = postes
        .dataset
        .prototype
        .replace(
            /__name__/g,
            postes.dataset.index
        );

    postes.appendChild(item);

    postes.dataset.index++;
    addTagFormDeleteLink(item);
};

document.querySelector('.add_item_link').addEventListener("click", addFormToCollection);

const postes = document.querySelector('#postes')

Array.from(document.querySelectorAll('.poste')).forEach(function (item) {
    addTagFormDeleteLink(item);
});