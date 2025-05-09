import { defineCollection, z } from "astro:content";

import { glob, file } from "astro/loaders";
import { rssSchema } from "@astrojs/rss";

const thinks = defineCollection({

    loader: glob({ pattern: "**/*.md", base: "./src/pages/thinks" }),
    schema: rssSchema,
});

export const collections = { thinks };