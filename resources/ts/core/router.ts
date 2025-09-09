interface RouteHandler {
    loader: () => Promise<void>;
}

export class Router {
    private routes: Map<string, RouteHandler> = new Map();
    private currentPath: string = window.location.pathname;

    register(path: string, loader: () => Promise<void>): void {
        this.routes.set(path, { loader });
    }

    private updateCurrentPath(): void {
        this.currentPath = window.location.pathname;
    }

    private matchPattern(pattern: string, path: string): boolean {
        if (pattern === path) return true;
        if (pattern.endsWith("*")) {
            return path.startsWith(pattern.slice(0, -1));
        }
        const patternParts = pattern.split("/").filter(Boolean);
        const pathParts = path.split("/").filter(Boolean);
        if (patternParts.length !== pathParts.length) return false;
        return patternParts.every(
            (part, i) => part.startsWith(":") || part === pathParts[i]
        );
    }

    async load(): Promise<void> {
        this.updateCurrentPath();

        for (const [pattern, handler] of this.routes) {
            if (this.matchPattern(pattern, this.currentPath)) {
                await handler.loader();
            }
        }
    }

    async init(): Promise<void> {
        await this.load();
        window.addEventListener("popstate", () => this.load());
    }

    getCurrentPath(): string {
        return this.currentPath;
    }
}
