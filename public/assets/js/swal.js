const swal = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    },
});
const confirm = Swal.mixin({
    icon: "question",
    showCancelButton: true,
    confirmButtonText: `<i class="bi bi-check-lg"></i> Ya`,
    cancelButtonText: `<i class="bi bi-x-lg"></i> Tidak`,
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading(),
});
