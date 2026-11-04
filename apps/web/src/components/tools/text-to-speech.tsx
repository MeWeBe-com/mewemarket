"use client";
import { useEffect, useState } from "react";
import { Pause, Play, Square, Volume2 } from "lucide-react";
import { Button, Field } from "@/components/ui";
import { Select, TextArea } from "./shared";

export default function TextToSpeech() {
  const [supported, setSupported] = useState(true);
  const [voices, setVoices] = useState<SpeechSynthesisVoice[]>([]);
  const [voice, setVoice] = useState("");
  const [text, setText] = useState("Hello! Type or paste some text here and press Speak to hear it read aloud.");
  const [rate, setRate] = useState(1);
  const [pitch, setPitch] = useState(1);
  const [status, setStatus] = useState<"idle" | "speaking" | "paused">("idle");

  useEffect(() => {
    if (typeof window === "undefined" || !("speechSynthesis" in window)) { setSupported(false); return; }
    const synth = window.speechSynthesis;
    const load = () => {
      const v = synth.getVoices();
      setVoices(v);
      setVoice((cur) => cur || (v.find((x) => x.default) ?? v.find((x) => x.lang.startsWith(navigator.language.slice(0, 2))) ?? v[0])?.voiceURI || "");
    };
    load();
    synth.addEventListener("voiceschanged", load);
    return () => { synth.removeEventListener("voiceschanged", load); synth.cancel(); };
  }, []);

  if (!supported) return <p className="rounded-lg border border-[var(--border)] bg-[var(--bg-subtle)] p-4 text-sm">Sorry, your browser doesn&apos;t support text to speech. Try a recent version of Chrome, Edge, Safari or Firefox.</p>;

  const speak = () => {
    const synth = window.speechSynthesis;
    synth.cancel();
    if (!text.trim()) return;
    const u = new SpeechSynthesisUtterance(text);
    const v = voices.find((x) => x.voiceURI === voice);
    if (v) { u.voice = v; u.lang = v.lang; }
    u.rate = rate; u.pitch = pitch;
    u.onend = u.onerror = () => setStatus("idle");
    synth.speak(u);
    setStatus("speaking");
  };

  return (
    <div className="space-y-4">
      <Field label="Text"><TextArea className="font-sans" value={text} onChange={(e) => setText(e.target.value)} /></Field>
      <div className="grid gap-4 sm:grid-cols-3">
        <Field label="Voice">
          <Select value={voice} onChange={(e) => setVoice(e.target.value)} disabled={!voices.length}>
            {!voices.length && <option value="">Loading voices…</option>}
            {voices.map((v) => <option key={v.voiceURI} value={v.voiceURI}>{v.name} ({v.lang})</option>)}
          </Select>
        </Field>
        <Field label={`Speed: ${rate.toFixed(1)}×`}><input type="range" min={0.5} max={2} step={0.1} value={rate} onChange={(e) => setRate(+e.target.value)} className="h-10 w-full" /></Field>
        <Field label={`Pitch: ${pitch.toFixed(1)}`}><input type="range" min={0} max={2} step={0.1} value={pitch} onChange={(e) => setPitch(+e.target.value)} className="h-10 w-full" /></Field>
      </div>
      <div className="flex flex-wrap gap-2">
        <Button type="button" onClick={speak} disabled={!text.trim()}><Volume2 className="size-4" aria-hidden /> Speak</Button>
        <Button type="button" variant="secondary" disabled={status !== "speaking"} onClick={() => { window.speechSynthesis.pause(); setStatus("paused"); }}><Pause className="size-4" aria-hidden /> Pause</Button>
        <Button type="button" variant="secondary" disabled={status !== "paused"} onClick={() => { window.speechSynthesis.resume(); setStatus("speaking"); }}><Play className="size-4" aria-hidden /> Resume</Button>
        <Button type="button" variant="secondary" disabled={status === "idle"} onClick={() => { window.speechSynthesis.cancel(); setStatus("idle"); }}><Square className="size-4" aria-hidden /> Stop</Button>
      </div>
      <p className="text-xs text-[var(--muted)]">Voices come from your device, so the list differs between browsers. Nothing is sent anywhere.</p>
    </div>
  );
}
