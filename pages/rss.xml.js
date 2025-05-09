import rss from "@astrojs/rss";
import { getCollection } from "astro:content";

export async function GET(context) {
  const thoughts = await getCollection("thinks");

  return rss({
    // `<title>` field in output xml
    title: "Pat thinks",
    // `<description>` field in output xml
    description:
      "A collection of Pats thoughts that can vary but might be seen as unhinged.",
    // Pull in your project "site" from the endpoint context
    // https://docs.astro.build/en/reference/api-reference/#site
    site: context.site,
    // Array of `<item>`s in output xml
    // See "Generating items" section for examples using content collections and glob imports
    items: [
      thoughts.map((post) => ({
        title: post.data.title,
        description: post.data.description,
        link: `/thinks/${post.url}/`,
        pubDate: post.data.date,
      })),
    ],
    customData: `<language>en-gb</language>`,
    // fuck the USA
  });
}
