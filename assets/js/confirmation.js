$(document).ready(() => {
  $("#btn-submit").addClass("disabled");

  let codes = [];
  let apiType;
  let codeStr = "";

  const arrOfInput = [`code1`, `code2`, `code3`, `code4`];

  const disabledSubmit = () => {
    codeStr = codes.map((code) => code?.value ?? "").join("");
    if (codeStr.length >= 4) {
      $("#btn-submit").focus();
      $("#btn-submit").prop("disabled", false);
      $("#btn-submit").removeClass("disabled");
    } else {
      $("#btn-submit").prop("disabled", true);
      $("#btn-submit").addClass("disabled");
    }
  };

  const pushToCodes = (id, value) => {
    const codeVal = { id, value };
    const isCodeExist = codes.find((code) => code?.id === id);

    if (isCodeExist) {
      codes = codes.map((code) =>
        code?.id === id ? { ...code, value } : code
      );
    } else {
      codes.push(codeVal);
    }
    disabledSubmit();
  };

  arrOfInput.map((input) => {
    $(`#${input}`).change((event) => {
      const { id, value } = event?.target;
      pushToCodes(id, value);
    });
  });

  $("#btn-submit").click((event) => {
    event?.preventDefault();
    apiType = "verify";

    $.ajax({
      url: "./api/auth.php",
      type: "POST",
      cache: false,
      data: {
        api: apiType,
      },
      success: (res, status, code) => {},
      error: (err) => {
        console.log(`Error: ${err}`);
      },
    });
  });
});
