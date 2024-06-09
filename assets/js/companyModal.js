!(() => {
  const $companyModal = document.querySelector('.js-company-modal')
  const $companyClose = document.querySelector('.js-company-close')
  const $companyBtn = document.querySelector('.js-show-company-modal')
  $companyBtn.addEventListener('click', (e) => {
    e.preventDefault()
    e.stopPropagation()
    $companyModal.classList.remove('hidden')
  })
  $companyClose.addEventListener('click', (e) => {
    e.preventDefault()
    e.stopPropagation()
    $companyModal.classList.add('hidden')
  })
})();
