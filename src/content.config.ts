import { defineCollection } from "astro:content";

import { glob } from "astro/loaders";
import { rssSchema } from "@astrojs/rss";

const thinks = defineCollection({
  loader: glob({ pattern: "**/*.md", base: "./src/pages/thinks" }),
  schema: rssSchema,
});

export const collections = { thinks };
