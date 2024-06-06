


!(() => {
  let currentStep = 0;
  const $ = document;
  const inputData = {
    name: '',
    birthYear: '',
    postalCode: '',
    prefecture: '',
    city: '',
    tel: '',
    email: '',
    streetAddress: '',
    employmentType: '', //ご希望の雇用形態は
    relocationTiming: '', // 転職時期
    pastJobChanges: '', // 
    currentJobStatus: '',
    feeling: '', // 最初の温度感の選択肢
    qualifications: [], // 資格
    liftingOperations: '', // お気持ちはどちらに近いですか？
    preferences: [] // こだわりの検索条件
  }

  // console.log("Console.inputData===",inputData)

  const $steps = $.querySelectorAll('.js-step');
  const $stepBtns = $.querySelectorAll('.js-step-btn');
  $stepBtns.forEach(
    ($stepBtn) => {
      $stepBtn.addEventListener('click', () => {
        const to = $stepBtn.getAttribute('step-to')
        stepTo(to)
      });
    }
  );

  const stepTo = (to) => {
    currentStep = parseInt(to)
    $steps.forEach(($step) => {
      if ($step.getAttribute('step') === to) {
        $step.classList.remove('hidden')
      } else {
        $step.classList.add('hidden')
      }
    })
    updateGuideArrow(currentStep)
  }

  const removeArrayValue = (arr, value) => {
    const index = arr.indexOf(value);
    if (index > -1) {
      arr.splice(index, 1)
    }
  }

  const updateNextBtnStatus = () => {
    if (inputData.qualifications.length <= 0) {
      $s1NextBtn.classList.remove('active')
      $s1NextBtn.classList.add('disabled')
    } else {
      $s1NextBtn.classList.add('active')
      $s1NextBtn.classList.remove('disabled')
      $s1ErrorLabel.classList.add('hidden')
    }

    if (inputData.liftingOperations === '') {
      $s6NextBtn.classList.remove('active')
      $s6NextBtn.classList.add('disabled')
    } else {
      $s6NextBtn.classList.add('active')
      $s6NextBtn.classList.remove('disabled')
      $s6ErrorLabel.classList.add('hidden')
    }
  }

  const $ErrorLabels = $.querySelectorAll('.js-error-label')
  const $multiSelectButtons = $.querySelectorAll('.js-multi-select-button')

  $multiSelectButtons.forEach(($btn) => {
    $btn.addEventListener('click', (e) => {
      const $b = e.currentTarget
      const val = $b.getAttribute('value')
      const key = $b.getAttribute('key')
      if (inputData[key].includes(val)) {
        $b.classList.remove('selected')
        removeArrayValue(inputData[key], val)
      } else {
        $b.classList.add('selected')
        inputData[key].push(val)
      }
      updateNextBtnStatus()
      updateGuideArrow()
    })
  })

  const $selectBtns = $.querySelectorAll('.js-select-button')
  $selectBtns.forEach(($btn) => {
    $btn.addEventListener('click', (e) => {
      const $b = e.currentTarget
      const val = $b.getAttribute('value')
      const key = $b.getAttribute('key')
      const to = $b.getAttribute('to')
      inputData[key] = val
      const $otherBtns = $.querySelectorAll(`.js-select-button[key="${key}"]`)
      $otherBtns.forEach(($ob) => {
        $ob.classList.remove('selected')
      })
      $b.classList.add('selected')
      $ErrorLabels.forEach(($el) => {
        $el.classList.add('hidden')
      })
      stepTo(to)
      updateNextBtnStatus()
    })
  })

  // step0 =============
  const $s0NextBtns = $.querySelectorAll('.js-feel-btn')
  $s0NextBtns.forEach(($btn) => $btn.addEventListener('click', (e) => {
    const $el = e.currentTarget
    const value = $el.value
    inputData.feeling = value
    const to = $el.getAttribute('step-to')
    stepTo(to)
  }))


  // step1 =============
  const $s1MoreBtn = $.querySelector('.js-step1-more-button-wrapper')
  const $s1AdditionalSelectors = $.querySelector('.js-step1-additional-selectors')
  $s1MoreBtn.addEventListener('click', () => {
    $s1MoreBtn.classList.add('hidden')
    $s1AdditionalSelectors.classList.remove('hidden')
  })
  const $s1ErrorLabel = $.querySelector('.js-s1-error-label')
  const $s1NextBtn = $.querySelector('.js-s1-next-btn')
  $s1NextBtn.addEventListener('click', () => {
    if (inputData.qualifications.length <= 0) {
      $s1ErrorLabel.classList.remove('hidden')
    } else {
      $s1ErrorLabel.classList.add('hidden')
      stepTo('2')
    }
  })
  // step1 end =============

  // step2 =================
  const $s2ErrorLabel = $.querySelector('.js-s2-error-label')
  const $s2NextBtn = $.querySelector('.js-s2-next-btn')
  $s2NextBtn.addEventListener('click', () => {
    if (inputData.employmentType === '') {
      $s2ErrorLabel.classList.remove('hidden')
    } else {
      $s2ErrorLabel.classList.add('hidden')
      stepTo('3')
    }
  })
  // step2 end =============

  // step3 =================
  const $s3ErrorLabel = $.querySelector('.js-s3-error-label')
  const $s3NextBtn = $.querySelector('.js-s3-next-btn')
  $s3NextBtn.addEventListener('click', () => {
    if (inputData.relocationTiming === '') {
      $s3ErrorLabel.classList.remove('hidden')
    } else {
      $s3ErrorLabel.classList.add('hidden')
      stepTo('4')
    }
  })
  // step3 end =============

  // step4 =================
  const $s4input = $.querySelector('.js-job-change-input')
  $s4input.addEventListener('change', (e) => {
    const $target = e.currentTarget
    inputData.pastJobChanges = $target.value
    if (inputData.pastJobChanges !== '') {
      stepTo('5')
    } else {
      $target.classList.add('error')
    }
  })

  const $s4ErrorLabel = $.querySelector('.js-s4-error-label')
  const $s4NextBtn = $.querySelector('.js-s4-next-btn')
  $s4NextBtn.addEventListener('click', () => {
    if (inputData.pastJobChanges === '') {
      $s4ErrorLabel.classList.remove('hidden')
    } else {
      $s4ErrorLabel.classList.add('hidden')
      stepTo('5')
    }
  })
  // step4 end =============

  // step5 =================
  const $s5ErrorLabel = $.querySelector('.js-s5-error-label')
  const $s5NextBtn = $.querySelector('.js-s5-next-btn')
  $s5NextBtn.addEventListener('click', () => {
    if (inputData.currentJobStatus === '') {
      $s5ErrorLabel.classList.remove('hidden')
    } else {
      $s5ErrorLabel.classList.add('hidden')
      stepTo('6')
    }
  })
  // step5 end =============

  // step6 =================
  const $s6ErrorLabel = $.querySelector('.js-s6-error-label')
  const $s6NextBtn = $.querySelector('.js-s6-next-btn')
  $s6NextBtn.addEventListener('click', () => {
    if (inputData.employmentType === '') {
      $s6ErrorLabel.classList.remove('hidden')
    } else {
      $s6ErrorLabel.classList.add('hidden')
      stepTo('7')
    }
  })
  // step6 end =============


  // step7 =================
  // step7 end =============

  // step8 =================
  const $addressToggle = $.querySelector('.js-address-form-toggle')
  const $addressForm = $.querySelector('.js-address-form')
  $addressToggle.addEventListener('click', () => {
    if ($addressForm.classList.contains('hidden')) {
      $addressForm.classList.remove('hidden')
      $addressToggle.classList.add('open')
    } else {
      $addressForm.classList.add('hidden')
      $addressToggle.classList.remove('open')
    }
    updateGuideArrow()
  })


  const $prefInput = $.querySelector('.js-pref-input')
  const $cityInput = $.querySelector('.js-city-input')
  const $addressInput = $.querySelector('.js-address-input')
  const $postalCodeInput = $.querySelector('.js-postalcode-input')

  $prefInput.innerHTML = `<option value="" >都道府県</option>`
    + Object.keys(__PISTON__.prefCity).map((pref) => (
      `<option value="${pref}">${pref}</option>`
    )).join('')

  const $jobCounters = document.querySelectorAll('.js-job-counter')
  $prefInput.addEventListener('change', (e) => {
    const $target = e.currentTarget
    const value = $target.value
    const cities = __PISTON__.prefCity[value]
    if (!cities) return
    $cityInput.innerHTML = `<option value="" hidden>市区町村を選択</option>`
      + cities.map((v) => (`<option value="${v}">${v}</option>`)).join('')
    inputData.prefecture = value
    inputData.city = ''
    resetPostalCode()
    updateGuideArrow()
    updateS8NextBtnStatus()
  })

  $cityInput.addEventListener('change', (e) => {
    const $target = e.currentTarget
    const value = $target.value
    inputData.city = value
    resetPostalCode()
    updateGuideArrow()
    updateS8NextBtnStatus()
  })

  $addressInput.addEventListener('change', (e) => {
    const $target = e.currentTarget
    const value = $target.value
    inputData.streetAddress = value
    resetPostalCode()
    updateGuideArrow()
    updateS8NextBtnStatus()
  })

  const validatePostalCode = (postalCode) => {
    if (postalCode.length === 7) {
      return true
    } else {
      return false
    }
  }

  $postalCodeInput.addEventListener('input', (e) => {
    const $target = e.currentTarget
    const value = $target.value
    inputData.postalCode = value
    if (validatePostalCode(value)) {
      // showJobCounters()
      // stepTo('9')
    } else {
      // hideJobCounters()
    }
    updateGuideArrow()
    updateS8NextBtnStatus()
  })

  const resetPostalCode = () => {
    $postalCodeInput.value = ''
    inputData.postalCode = ''
  }

  const hideJobCounters = () => {
    $jobCounters.forEach(($el) => $el.classList.add('hidden'))
  }

  const showJobCounters = () => {
    // 消す
    // $jobCounters.forEach(($el) => $el.classList.remove('hidden'))
  }

  const $s8ErrorLabel = $.querySelector('.js-s8-error-label')
  const $s8NextBtn = $.querySelector('.js-s8-next-btn')
  $s8NextBtn.addEventListener('click', () => {
    const {
      postalCode,
      prefecture,
      city,
      streetAddress
    } = inputData
    if (validatePostalCode(postalCode) || (prefecture && city && streetAddress)) {
      $s8ErrorLabel.classList.add('hidden')
      stepTo('9')
    } else {
      $s8ErrorLabel.classList.remove('hidden')
    }
  })

  const updateS8NextBtnStatus = () => {
    const {
      postalCode,
      prefecture,
      city,
      streetAddress
    } = inputData
    if (validatePostalCode(postalCode) || (prefecture && city && streetAddress)) {
      $s8NextBtn.classList.add('active')
      $s8NextBtn.classList.remove('disabled')
      $s8ErrorLabel.classList.add('hidden')
    } else {
      $s8NextBtn.classList.remove('active')
      $s8NextBtn.classList.add('disabled')
    }
  }

  // step8 end =============

  // step9 =================
  const $s9ErrorLabel = $.querySelector('.js-s9-error-label')
  const $s9NextBtn = $.querySelector('.js-s9-next-btn')
  $s9NextBtn.addEventListener('click', () => {
    if (inputData.birthYear === '' || inputData.name === '') {
      $s9ErrorLabel.classList.remove('hidden')

      if (inputData.name === '') {
        $target.classList.add('error')
      }
      if (inputData.birthYear === '') {
        $target.classList.add('error')
      }
    } else {
      $s9ErrorLabel.classList.add('hidden')
      stepTo('10')
    }
  })

  const updateS9NextBtnStatus = () => {

    if (inputData.birthYear === '' || inputData.name === '') {
      $s9NextBtn.classList.remove('active')
      $s9NextBtn.classList.add('disabled')
    } else {
      $s9NextBtn.classList.add('active')
      $s9NextBtn.classList.remove('disabled')
      $s9ErrorLabel.classList.add('hidden')
    }
  }

  const $inputName = $.querySelector('.js-input-name')
  $inputName.addEventListener('change', (e) => {
    const $target = e.currentTarget
    inputData.name = $target.value

    $balloonName.innerText = sanitize(inputData.name)
    if (inputData.name === '') {
      $target.classList.add('error')
    }
    updateS9NextBtnStatus()
    updateGuideArrow()
  })

  const $inputBirthYear = $.querySelector('.js-input-birth-year')
  $inputBirthYear.addEventListener('change', (e) => {
    const $target = e.currentTarget
    inputData.birthYear = $target.value
    if (inputData.birthYear === '') {
      $target.classList.add('error')
    }
    updateS9NextBtnStatus()
    updateGuideArrow()
  })
  // step9 end =============

  // step10 =================
  const $s10ErrorLabel = $.querySelector('.js-s10-error-label')
  const $balloonName = $.querySelector('.js-balloon-name')
  const sanitize = (str) => {
    return str.replace(/&/g, '＆')
      .replace(/</g, '＜')
      .replace(/>/g, '＞')
      .replace(/"/g, '”')
      .replace(/'/g, '’')
      .replace(/\?/g, '？');
  }

  const validateEmail = (val) => {
    // - [ ]  未入力はOK
    if (!val) {
      return true
    }

    // - [ ]  メールアドレスに@がない場合にCVボタンを押すとはエラー表示
    if (!val.includes('@')) {
      return 'メールアドレスに@がありません'
    }
    // - [ ]  メールアドレスの形式が正しくない場合はバリデーションエラー
    if (!/^.+@.+$/.test(val)) {
      return 'メールアドレスの形式が正しくありません'
    }
    return true
  }

  const validateTel = (val) => {
    if (!val) {
      return '電話番号を入力してください'
    }
    // - [ ]  0から始まっていない
    if (!/^0.*/.test(val)) {
      return '電話番号は0から始めてください'
    }
    // - [ ]  ハイフンが入っている
    if (val.includes('-')) {
      return '電話番号にハイフンが含まれています'
    }
    // - [ ]  半角数字以外が入っている
    if (!/^[0-9]*$/.test(val)) {
      return '半角数字で入力してください'
    }
    // - [ ]  10-11の範囲
    if (!/^[0-9]{10,11}$/.test(val)) {
      return '電話番号は10-11桁で入力してください'
    }
    return true
  }

  const validateS10 = () => {
    const tel = $inputTel.value;
    const email = $inputEmail.value;
    let result = validateTel(tel);
    if (result === true) {
      result = validateEmail(email);
    }
    if (result === true) {
      return true;
    } else {
      $s10ErrorLabel.innerText = result;
      return false;
    }
  }
  const $inputTel = $.querySelector('.js-input-tel')
  $inputTel.addEventListener('change', (e) => {
    const $target = e.currentTarget
    inputData.tel = $target.value
    if (validateTel(inputData.tel)) {
    }
    updateCvBtnStatus()
    updateGuideArrow()
  })
  const $inputEmail = $.querySelector('.js-input-email')
  $inputEmail.addEventListener('change', (e) => {
    const $target = e.currentTarget
    inputData.email = $target.value
    if (validateEmail(inputData.email)) {
    }
    updateCvBtnStatus()
    updateGuideArrow()
  })

  const $cvBtn = $.querySelector('.js-cv-btn')
  const updateCvBtnStatus = () => {
    if (validateS10()) {
      $cvBtn.classList.add('active')
      $s10ErrorLabel.classList.add('hidden')
    } else {
      $cvBtn.classList.remove('active')
      $s10ErrorLabel.classList.remove('hidden')
    }
  }

  $cvBtn.addEventListener('click', () => {
    if (!validateS10()) {
      $s10ErrorLabel.classList.remove('hidden')
    } else {
      hideGuideArrow()
      submit()
    }
  })

  let isSubmitting = false
  const submit = () => {
    if (isSubmitting === true) return
    isSubmitting = true
    const method = "POST";
    const body = JSON.stringify(inputData);
    const headers = {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'x-api-key': window.__PISTON__.key
    }
    const url = window.__PISTON__.submitUrl

    fetch(url, { method, headers, body })
      .then((res) => {
        // stepTo('11')
        isSubmitting = false
      })
    // .catch( () => {
    //   window.alert('送信に失敗しました')
    //   isSubmitting = false
    // });
    setTimeout(() => {
      // const url = `${location.origin}/lp001/complete`

      const url = `./lp001/complete.html`
      location.href = url
    }, 300)
  }

  // location.replace(location.origin + "/lp001/complete")
  // step10 end =============

  // guide arrows
  const $guideArrow = $.querySelector('.js-guide-arrow')
  const ARROW_MARGIN_Y = -10
  const updateGuideArrowPos = ($target) => {
    const bound = $target.getBoundingClientRect()
    let x = bound.x + bound.width + window.scrollX;
    let y = bound.y + window.scrollY + ARROW_MARGIN_Y;
    $guideArrow.style.transform = `translate3d(${x}px, ${y}px, 0)`
  }

  const $guideOverlays = $.querySelectorAll('.js-overlay')
  const $guideS0_1 = $.querySelector('.js-guide-s0-1')
  const $guideS1_1 = $.querySelector('.js-guide-s1-1')
  const $guideS1_2 = $.querySelector('.js-guide-s1-2')
  const $guideS2_1 = $.querySelector('.js-guide-s2-1')
  const $guideS2_2 = $.querySelector('.js-guide-s2-2')
  const $guideS2_overlay = $.querySelector('.js-guide-s2-overlay')
  const $guideS3_1 = $.querySelector('.js-guide-s3-1')
  const $guideS3_2 = $.querySelector('.js-guide-s3-2')
  const $guideS4_1 = $.querySelector('.js-guide-s4-1')
  const $guideS4_2 = $.querySelector('.js-guide-s4-2')
  const $guideS5_1 = $.querySelector('.js-guide-s5-1')
  const $guideS5_2 = $.querySelector('.js-guide-s5-2')
  const $guideS6_1 = $.querySelector('.js-guide-s6-1')
  const $guideS6_2 = $.querySelector('.js-guide-s6-2')
  const $guideS7_1 = $.querySelector('.js-guide-s7-1')
  const $guideS7_2 = $.querySelector('.js-guide-s7-2')
  const $guideS7_overlay = $.querySelector('.js-guide-s7-overlay')
  const $guideS8_1 = $.querySelector('.js-guide-s8-1')
  const $guideS8_2 = $.querySelector('.js-guide-s8-2')
  const $guideS8_3 = $.querySelector('.js-guide-s8-3')
  const $guideS8_4 = $.querySelector('.js-guide-s8-4')
  const $guideS8_5 = $.querySelector('.js-guide-s8-5')
  const $guideS8_overlay = $.querySelector('.js-guide-s8-overlay')
  const $guideS9_1 = $.querySelector('.js-guide-s9-1')
  const $guideS9_2 = $.querySelector('.js-guide-s9-2')
  const $guideS9_3 = $.querySelector('.js-guide-s9-3')
  const $guideS9_overlay = $.querySelector('.js-guide-s9-overlay')
  const $guideS10_1 = $.querySelector('.js-guide-s10-1')
  const $guideS10_2 = $.querySelector('.js-guide-s10-2')
  const $guideS10_3 = $.querySelector('.js-guide-s10-3')
  const $guideS10_overlay = $.querySelector('.js-guide-s10-overlay')

  const updateGuideArrow = () => {
    hideOverlays()
    const updateS0 = () => {
      updateGuideArrowPos($guideS0_1)
      setTimeout(() => {
        showGuideArrow()
      }, 500)
    }

    const updateS1 = () => {
      // qualifications: [], //資格
      if (inputData.qualifications.length <= 0) {
        updateGuideArrowPos($guideS1_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS1_2)
        showGuideArrow()
      }
    }

    const updateS2 = () => {
      // employmentType: '',
      if (!inputData.employmentType) {
        updateGuideArrowPos($guideS2_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS2_2)
        showGuideArrow()
        $guideS2_overlay.classList.remove('hidden')
      }
    }


    const updateS3 = () => {
      // relocationTiming: '',
      if (!inputData.relocationTiming) {
        updateGuideArrowPos($guideS3_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS3_2)
        showGuideArrow()
      }
    }

    const updateS4 = () => {
      // pastJobChanges: '',
      if (!inputData.pastJobChanges) {
        updateGuideArrowPos($guideS4_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS4_2)
        showGuideArrow()
      }
    }

    const updateS5 = () => {
      // currentJobStatus
      if (!inputData.currentJobStatus) {
        updateGuideArrowPos($guideS5_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS5_2)
        showGuideArrow()
      }
    }

    const updateS6 = () => {
      // liftingOperations: '', //
      if (!inputData.liftingOperations) {
        updateGuideArrowPos($guideS6_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS6_2)
        showGuideArrow()
      }
    }

    const updateS7 = () => {
      // preferences: [] // こだわりの検索条件
      if (inputData.preferences.length <= 0) {
        updateGuideArrowPos($guideS7_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS7_2)
        showGuideArrow()
      }
    }

    const updateS8 = () => {
      // postalCode: '',
      // prefecture: '',
      // city: '',
      // streetAddress: '',
      $guideS8_overlay
      const {
        prefecture,
        city,
        streetAddress,
        postalCode
      } = inputData

      if ($addressForm.classList.contains('hidden')) {
        if (validatePostalCode(postalCode)) {
          updateGuideArrowPos($guideS8_5)
          showGuideArrow()
        } else {
          updateGuideArrowPos($guideS8_1)
          showGuideArrow()
        }
      } else {
        if (!prefecture) {
          updateGuideArrowPos($guideS8_2)
          showGuideArrow()
        } else if (!city) {
          updateGuideArrowPos($guideS8_3)
          showGuideArrow()
        } else if (!streetAddress) {
          updateGuideArrowPos($guideS8_4)
          showGuideArrow()
        }

        if (validatePostalCode(postalCode) || (prefecture && city && streetAddress)) {
          updateGuideArrowPos($guideS8_5)
          showGuideArrow()
        }
      }

    }

    const updateS9 = () => {
      // name: '',
      // birthYear: '',
      $guideS9_1
      $guideS9_2
      $guideS9_3
      if (!inputData.name) {
        updateGuideArrowPos($guideS9_1)
        showGuideArrow()
      } else if (!inputData.birthYear) {
        updateGuideArrowPos($guideS9_2)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS9_3)
        showGuideArrow()
        $guideS9_overlay.classList.remove('hidden')
      }
      $guideS9_overlay
    }

    const updateS10 = () => {
      // tel: '',
      // email: '',
      // $guideS10_1
      // $guideS10_2
      // $guideS10_3
      // $guideS10_overlay
      if (!validateS10()) {
        updateGuideArrowPos($guideS10_1)
        showGuideArrow()
      } else {
        updateGuideArrowPos($guideS10_3)
        showGuideArrow()
        $guideS10_overlay.classList.remove('hidden')
      }

    }
    switch (currentStep) {
      case 0:
        updateS0();
        break;
      case 1:
        updateS1();
        break;
      case 2:
        updateS2();
        break;
      case 3:
        updateS3();
        break;
      case 4:
        updateS4();
        break;
      case 5:
        updateS5();
        break;
      case 6:
        updateS6();
        break;
      case 7:
        updateS7();
        break;
      case 8:
        updateS8();
        break;
      case 9:
        updateS9();
        break;
      case 10:
        updateS10();
        break;
    }
  }

  const hideOverlays = () => {
    $guideOverlays.forEach(($o) => $o.classList.add('hidden'))
  }

  const hideGuideArrow = () => {
    $guideArrow.classList.add('hidden')
  }

  const showGuideArrow = () => {
    $guideArrow.classList.remove('hidden')
  }

  $guideOverlays.forEach(($o) => {
    $o.addEventListener('click', () => hideOverlays())
  })
  updateGuideArrow()
  window.addEventListener('resize', () => updateGuideArrow())
})();






//============================//
// === companyModal.js === //
//============================//

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
