import rss, { pagesGlobToRssItems } from "@astrojs/rss";
import { getCollection } from "astro:content";

export async function GET(context) {

  const takes = await getCollection("thinks")

  return rss({
    title: "Pat thinks",
    description: "A collection of Pat's thoughts that can vary but might be seen as unhinged.",
    site: context.site,
    items: takes.map((take) => ({
      title: take.data.title,
      pubDate: take.data.pubDate,
      link: `/thinks/${take.id}`
    })),
  });
}