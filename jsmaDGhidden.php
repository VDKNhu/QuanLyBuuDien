<script>
    const maDG= document.getElementById("madocgia").textContent;
    console.log(maDG);
    const MADG = document.querySelectorAll(".maDGhidden");
    for(let i = 0; i < MADG.length; i++){
        MADG[i].value = maDG;
        console.log(MADG[i]);
    }
</script>
