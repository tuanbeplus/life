import useModal from '#/useModal.js'

const { Modal } = useModal()
const modal = new Modal()

const openModal = () => {
  modal.open()
}

const fields = {
  en: {
    first_name: {
      label: 'First name',
    },
    last_name: {
      label: 'Last name',
    },
    phone: {
      label: 'Mobile Phone',
      validation: {
        title: 'Enter 10 digit phone number without spaces',
        type_message: 'Please enter a 10 digit phone number. Numbers only.',
        type: 'number',
        maxlength: '10',
        minlength: '10',
      },
    },
    email: {
      label: 'Email',
      validation: {
        parsley_type_message: 'XXXX',
      },
    },
    currently_gdm: {
      label: 'Are you currently pregnant with gestational diabetes?',
      options: {
        Yes: 'Yes',
        No: 'No',
      },
    },
    due_date: {
      label: 'What is your due date?',
    },
    heard_about_via: {
      label: 'How did you first hear about us?',
      placeholder: 'Please select...',
      options: {
        'NDSS email': 'NDSS email',
        'Maternal Child Health': 'Maternal Child Health',
        'GDM Flyer': 'GDM Flyer',
        'GDM Brochure': 'GDM Brochure',
        'Hospital': 'Hospital',
        'GP': 'GP',
        'Google Search': 'Google Search',
        'Word of Mouth': 'Word of Mouth',
        'Health Professional': 'Health Professional',
        'Other': 'Other',
      },
    },
    consent: {
      label: 'I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.',
    },
  },
  vi: {
    first_name: {
      label: 'Tên',
    },
    last_name: {
      label: 'Họ',
    },
    phone: {
      label: 'Số điện thoại',
      validation: {
        title: 'Enter 10 digit phone number without spaces',
        type_message: 'Please enter a 10 digit phone number. Numbers only.',
        type: 'number',
        maxlength: '10',
        minlength: '10',
      },
    },
    email: {
      label: 'Địa chỉ email',
      validation: {
        parsley_type_message: 'XXXX',
      },
    },
    currently_gdm: {
      label: 'Hiện bạn có đang mang thai và bị tiểu đường thai kỳ không?',
      options: {
        Yes: 'Có',
        No: 'Không',
      },
    },
    due_date: {
      label: 'Ngày dự sinh của bạn là ngày mấy?',
    },
    heard_about_via: {
      label: 'Bạn đã nghe về chúng tôi từ ở đâu?',
      placeholder: 'Vui lòng chọn...',
      options: {
        'NDSS email': 'Qua email NDSS',
        'Maternal Child Health': 'Chăm sóc sức khỏe mẫu nhi',
        'GDM Flyer': 'Tờ rơi về bệnh tiểu đường sau thai kỳ',
        'GDM Brochure': 'Tờ thông tin về bệnh tiểu đường sau thai kỳ',
        'Hospital': 'bệnh viện',
        'GP': 'bác sĩ gia đình',
        'Google Search': 'tìm kiếm từ Google',
        'Word of Mouth': 'Truyền miệng',
        'Health Professional': 'Chuyên viên Y Tế',
        'Other': 'chỗ khác',
      },
    },
    Do_you_need_an_interpreter__c: {
      label: 'Bạn có cẫn thông dịch viên không?',
      options: {
        Yes: 'Có',
        No: 'Không',
      },
    },
    Vietnamese_woman__c: {
      label: 'Tôi là một phụ nữ Việt Nam',
    },
    Program_to_be_deliver_Vietnamese__c: {
      label: 'Bạn có cần chương trình được cung cấp bằng tiếng Việt không?',
      options: {
        Yes: 'Có',
        No: 'Không',
      },
    },
    consent: {
      label: 'Tôi đồng ý cho nhân viên của Diabetes Victoria từ chương trình <em>Life!</em> Program liên hệ với tôi về chương trình này và cho bất kỳ thông tin cá nhân nào được thu thập để sử dụng cho các hoạt động quản trị của chương trình <em>Life!</em>',
    },
  },
}


export default () => {
  return {
    modal,
    openModal,
    fields,
  }
}