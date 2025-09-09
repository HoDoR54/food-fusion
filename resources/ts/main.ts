import { Router } from "./core/router";
import { Home } from "./modules/home";

const router = new Router();

router.register("/", async () => {
    new Home();
});

router.init();
