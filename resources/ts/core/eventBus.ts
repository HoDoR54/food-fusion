type Callback = (data?: any) => void;

export class EventBus {
    private events: Record<string, Callback[]>;

    constructor() {
        this.events = {};
    }

    on(event: string, callback: Callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }

    emit(event: string, data?: any) {
        if (this.events[event]) {
            this.events[event].forEach((callback) => callback(data));
        }
    }

    off(event: string, callback: Callback) {
        if (!this.events[event]) return;
        this.events[event] = this.events[event].filter((cb) => cb !== callback);
    }

    clear(event: string) {
        if (this.events[event]) {
            delete this.events[event];
        }
    }
}
